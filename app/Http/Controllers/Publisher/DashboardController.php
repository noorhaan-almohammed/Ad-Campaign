<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PublisherTask;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
{
    /**
     * @var User $user
     */
    $user = Auth::user();

    $wallet = $user->wallet;
    $balance = $wallet?->balance ?? 0;

    $tasksCompleted = PublisherTask::where('publisher_id', $user->id)
        ->where('status', 'approved')
        ->count();

    $tasksPending = PublisherTask::where('publisher_id', $user->id)
        ->where('status', 'pending')
        ->count();

    // جلب طلبات السحب الخاصة بالناشر
    $withdrawRequests = $user->withdrawRequests()
        ->latest()
        ->get();

    return view('publisher.dashboard', compact(
        'tasksCompleted',
        'tasksPending',
        'balance',
        'withdrawRequests'
    ));
}

}
