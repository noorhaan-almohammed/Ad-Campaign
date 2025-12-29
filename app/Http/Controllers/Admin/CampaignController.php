<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(15);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function approve(Campaign $campaign)
    {
        DB::transaction(function () use ($campaign) {
            $campaign->update(['status' => 'approved']);
            $user = Auth::user();
            $user->wallet->increment('balance', $campaign->budget);

            $advertiser = $campaign->user;
            $advertiser->wallet->decrement('balance', $campaign->budget);

            // إنشاء فاتورة
            Invoice::create([
                'user_id'     => $advertiser->id,
                'campaign_id' => $campaign->id,
                'amount'      => $campaign->budget,
                'status'      => 'paid',
                'due_date'    => now(),
            ]);
        });
        return back()->with('success', 'Campaign approved successfully.');
    }

    public function reject(Campaign $campaign)
    {
        $campaign->update(['status' => 'rejected']);
        return back()->with('success', 'Campaign rejected.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Campaign deleted successfully.');
    }
}
