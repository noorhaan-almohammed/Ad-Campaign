<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\CampaignTask;
use App\Models\PublisherTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = PublisherTask::where('publisher_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('publisher.tasks.index', compact('tasks'));
    }

    public function show(PublisherTask $task)
    {
        if ($task->publisher_id !== Auth::id()) {
            abort(403);
        }

        return view('publisher.tasks.show', compact('task'));
    }
    public function execute(CampaignTask $task)
    {
        PublisherTask::create([
            'publisher_id' => Auth::id(),
            'campaign_id'      => $task->campaign_id,
            'campaign_task_id'      => $task->id,
            'reward'       => $task->reward,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Task submitted for review.');
    }
    public function submit(Request $request, PublisherTask $task)
    {
        if ($task->publisher_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'proof_file' => 'nullable|file|max:50000',
            'proof_link' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('tasks/proofs', 'public');
            $task->proof_file = $path;
        }

        if (!empty($data['proof_link'])) {
            $task->proof_link = $data['proof_link'];
        }
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = $user->wallet->create(['balance' => 0, 'locked_balance' => 0]);
        }
        $wallet->locked_balance += $task->reward;
        $wallet->save();

        $task->status = 'waiting_review';
        $task->save();

        return back()->with('success', 'Task submitted successfully!');
    }
}
