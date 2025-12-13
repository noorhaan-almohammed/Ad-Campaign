<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignMedia;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('user_id', Auth::id())->latest()->paginate(10);

        return view('advertiser.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('advertiser.campaigns.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'description'  => 'required|string',
            'budget'       => 'required|numeric|min:1',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',

            // Media
            'media_files.*' => 'nullable|file|max:50000',
            'media_links.*' => 'nullable|string',

            // Tasks
            'tasks'                       => 'nullable|array',
            'tasks.*.title'               => 'required_with:tasks|string',
            'tasks.*.description'         => 'nullable|string',
            'tasks.*.reward'              => 'required_with:tasks|numeric|min:0',
            'tasks.*.max_completions'     => 'required_with:tasks|integer|min:1',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if ($wallet->balance < $data['budget']) {
            return back()->withErrors(['budget' => 'Insufficient wallet balance.']);
        }

        // خصم الرصيد
        $wallet->balance -= $data['budget'];
        $wallet->save();

        // إنشاء الحملة
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        $campaign = Campaign::create($data);
        $campaign->update(['remaining_budget' => $data['budget']]);
        // إنشاء فاتورة
        Invoice::create([
            'user_id'     => $user->id,
            'campaign_id' => $campaign->id,
            'amount'      => $campaign->budget,
            'status'      => 'paid',
            'due_date'    => now(),
        ]);

        // إنشاء سجل الحركة المالية
        Transaction::create([
            'user_id' => $user->id,
            'amount'  => $campaign->budget,
            'type'    => 'campaign_payment',
            'reference' => 'Campaign ID: ' . $campaign->id,
            'notes'   => 'Payment for campaign creation',
        ]);

        /*-------------------------------------------
     |  Save Campaign Tasks
     -------------------------------------------*/
        if (!empty($data['tasks'])) {
            foreach ($data['tasks'] as $task) {
                $campaign->tasks()->create([
                    'title'           => $task['title'],
                    'description'     => $task['description'] ?? '',
                    'reward'          => $task['reward'],
                    'max_completions' => $task['max_completions'],
                    'status'          => 'active',
                ]);
            }
        }

        /*-------------------------------------------
     |  Upload Media
     -------------------------------------------*/
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('campaigns', 'public');
                $type = $this->detectFileType($file);

                CampaignMedia::create([
                    'campaign_id' => $campaign->id,
                    'file_path'   => $path,
                    'type'        => $type,
                ]);
            }
        }

        if (!empty($request->media_links)) {
            foreach ($request->media_links as $link) {
                if (!empty($link)) {
                    CampaignMedia::create([
                        'campaign_id' => $campaign->id,
                        'url'         => $link,
                        'type'        => 'link',
                    ]);
                }
            }
        }

        return redirect()->route('advertiser.campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }




    public function edit(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        return view('advertiser.campaigns.edit', compact('campaign'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Campaign $campaign
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $data = $request->validate([
            'name'         => 'nullable|string',
            'description'  => 'nullable|string',
            'budget'       => 'nullable|numeric|min:1',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after:start_date',

            // Media
            'media_files.*' => 'nullable|file|max:50000',
            'media_links.*' => 'nullable|string',

            // Tasks
            'tasks'                       => 'nullable|array',
            'tasks.*.id'                  => 'nullable|exists:campaign_tasks,id',
            'tasks.*.title'               => 'required_with:tasks|string',
            'tasks.*.description'         => 'nullable|string',
            'tasks.*.reward'              => 'required_with:tasks|numeric|min:0',
            'tasks.*.max_completions'     => 'required_with:tasks|integer|min:1',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        $oldBudget = $campaign->budget;
        $newBudget = $data['budget'] ?? $oldBudget;

        // في حالة زيادة الميزانية فقط
        if ($newBudget > $oldBudget) {
            $difference = $newBudget - $oldBudget;

            if ($wallet->balance < $difference) {
                return back()->withErrors(['budget' => 'Insufficient wallet balance.']);
            }

            $wallet->balance -= $difference;
            $wallet->save();

            $campaign->update([
                'budget'      => $newBudget,
            ]);

            Invoice::create([
                'user_id'     => $user->id,
                'campaign_id' => $campaign->id,
                'amount'      => $difference,
                'status'      => 'paid',
                'due_date'    => now(),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'amount'  => $difference,
                'type'    => 'campaign_budget_update',
                'reference' => 'Campaign ID: ' . $campaign->id,
                'notes'   => 'Increased budget for campaign',
            ]);
        } elseif ($newBudget <= $oldBudget) {
            // لا تقبل تقليل الميزانية و اعرض خطأ 403 بال validation
            return back()->withErrors(['budget' => 'Reducing budget is not allowed.']);
        }

        // تحديث بيانات الحملة
        $campaign->update([
            'name'        => $data['name'] ?? $campaign->name,
            'description' => $data['description'] ?? $campaign->description,
            'start_date'  => $data['start_date'] ?? $campaign->start_date,
            'end_date'    => $data['end_date'] ?? $campaign->end_date,
        ]);

        /*-------------------------------------------
     |  Update / Add / Delete Tasks
     -------------------------------------------*/
        $existingTaskIds = $campaign->tasks()->pluck('id')->toArray();
        $receivedTaskIds = [];

        if (!empty($data['tasks'])) {
            foreach ($data['tasks'] as $task) {

                // تعديل مهمة موجودة
                if (!empty($task['id'])) {
                    $receivedTaskIds[] = $task['id'];

                    $campaign->tasks()->where('id', $task['id'])->update([
                        'title'           => $task['title'],
                        'description'     => $task['description'] ?? '',
                        'reward'          => $task['reward'],
                        'max_completions' => $task['max_completions'],
                    ]);
                } else {
                    // إضافة مهمة جديدة
                    $campaign->tasks()->create([
                        'title'           => $task['title'],
                        'description'     => $task['description'] ?? '',
                        'reward'          => $task['reward'],
                        'max_completions' => $task['max_completions'],
                        'status'          => 'active',
                    ]);
                }
            }
        }

        // حذف المهام التي لم تعد موجودة في الفورم
        $tasksToDelete = array_diff($existingTaskIds, $receivedTaskIds);
        if (!empty($tasksToDelete)) {
            $campaign->tasks()->whereIn('id', $tasksToDelete)->delete();
        }

        /*-------------------------------------------
     |  Media Upload
     -------------------------------------------*/
        if (!empty($data['media_files'])) {
            foreach ($data['media_files'] as $file) {
                $path = $file->store('campaigns', 'public');
                $type = $this->detectFileType($file);

                CampaignMedia::create([
                    'campaign_id' => $campaign->id,
                    'file_path'   => $path,
                    'type'        => $type,
                ]);
            }
        }

        if (!empty($data['media_links'])) {
            foreach ($data['media_links'] as $link) {
                if (!empty($link)) {
                    CampaignMedia::create([
                        'campaign_id' => $campaign->id,
                        'url'         => $link,
                        'type'        => 'link',
                    ]);
                }
            }
        }

        return back()->with('success', 'Campaign updated successfully');
    }



    public function deleteCampaignMedia(CampaignMedia $media)
    {
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return response()->json(['success' => true]);
    }


    public function destroy(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $campaign->delete();

        return back()->with('success', 'تم حذف الحملة');
    }

    private function authorizeCampaign(Campaign $campaign)
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
    private function detectFileType($file)
    {
        $mime = $file->getMimeType();

        if (str_contains($mime, 'image')) return 'image';
        if (str_contains($mime, 'video')) return 'video';
        return 'file';
    }
}
