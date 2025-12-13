<?php

namespace App\Http\Controllers\Advertiser;

use App\Models\PublisherTask;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TaskController
{
    public function index()
    {
        $tasks = PublisherTask::where('status','!=','pending')
        ->whereHas('campaign', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->latest()
            ->paginate(10);

        return view('advertiser.campaigns.tasks.index', compact('tasks'));
    }

    public function review(PublisherTask $task)
    {
        if ($task->campaign->user_id !== Auth::id()) {
            abort(403);
        }
        return view('advertiser.campaigns.tasks.review', compact('task'));
    }

    public function approve(PublisherTask $task)
    {
        if ($task->campaign->user_id !== Auth::id()) {
            abort(403);
        }

        // سحب المبلغ من ميزانية الحملة
        if ( $task->campaign->remaining_budget < $task->reward ) {
            return back()->with('error', 'Insufficient campaign budget to approve this task.');
        }
        $task->campaign->remaining_budget -= $task->reward;
        $task->campaign->save();

        // تحديث المحفظة: نقل المبلغ من locked إلى balance
        $pub_wallet = $task->publisher->wallet;
        $pub_wallet->locked_balance -= $task->reward;
        $pub_wallet->balance += $task->reward;
        $pub_wallet->save();

        $task->status = 'approved';
        $task->save();

        return back()->with('success', 'Task approved successfully!');
    }

    public function reject(PublisherTask $task)
    {
        if ($task->campaign->user_id !== Auth::id()) {
            abort(403);
        }

        // إعادة المبلغ من locked_balance
        $pub_wallet = $task->publisher->wallet;
        $pub_wallet->locked_balance -= $task->reward;
        $pub_wallet->save();

        $task->status = 'rejected';
        $task->save();

        return back()->with('success', 'Task rejected.');
    }
}
