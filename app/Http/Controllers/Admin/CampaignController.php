<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

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
        $campaign->update(['status' => 'approved']);
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
