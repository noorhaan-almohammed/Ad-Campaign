<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\PublisherTask;
use Illuminate\Support\Facades\Auth;

class EarningsController extends Controller
{
    public function index()
    {
        $earnings = PublisherTask::where('publisher_id', Auth::id())
            ->where('status', 'approved')
            ->paginate(10);


        $total = PublisherTask::where('publisher_id', Auth::id())
            ->where('status', 'approved')
            ->sum('reward');

        return view('publisher.earnings.index', compact('earnings', 'total'));
    }
}
