<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignTask;
use Illuminate\Http\Request;

class CampaignTaskController extends Controller
{
    /** عرض صفحة تعديل مهام الحملة */
    public function edit(Campaign $campaign)
    {
        $campaign->load('tasks');

        return view('advertiser.campaigns.tasks.edit', compact('campaign'));
    }

    /** حفظ التعديلات */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'nullable|exists:campaign_tasks,id',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.reward' => 'required|numeric|min:0',
            'tasks.*.max_completions' => 'required|integer|min:1',
            'tasks.*.status' => 'required|in:active,paused',
        ]);

        foreach ($validated['tasks'] as $taskData) {
            if (isset($taskData['id'])) {
                // تحديث المهمة
                CampaignTask::where('id', $taskData['id'])
                    ->where('campaign_id', $campaign->id)
                    ->update($taskData);
            } else {
                // إنشاء مهمة جديدة
                $campaign->tasks()->create($taskData);
            }
        }

        return redirect()
            ->route('advertiser.campaigns.tasks.edit', $campaign->id)
            ->with('success', 'Tasks updated successfully!');
    }
}
