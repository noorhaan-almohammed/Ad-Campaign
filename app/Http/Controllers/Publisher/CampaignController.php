<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'approved')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>', now())
            ->whereHas('tasks') // حملات فيها Tasks
            ->whereHas('tasks', function ($q) {
                $q->select('campaign_id')
                    ->groupBy('campaign_id')
                    ->havingRaw('MIN(reward) <= (SELECT remaining_budget FROM campaigns WHERE campaigns.id = campaign_id)');
            })
            ->with('tasks') // تحميل المهام مع الحملات
            ->latest()
            ->paginate(10);

        return view('publisher.campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        // تحميل المهام ثم تصفيتها حسب الميزانية المتبقية
        $tasks = $campaign->tasks()
            ->where('reward', '<=', $campaign->remaining_budget)
            ->get();

        return view('publisher.campaigns.show', compact('campaign', 'tasks'));
    }
}
