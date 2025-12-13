<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdvertisers = User::role('advertiser')->count();
        $totalPublishers = User::role('publisher')->count();
        $totalCampaigns = Campaign::count();
        $pendingCampaigns = Campaign::where('status', 'pending')->count();
        $totalWithdrawRequests = WithdrawRequest::count();
        $user = Auth::user();

        $wallet = $user->wallet;
        $balance = $wallet?->balance ?? 0;

        return view('admin.dashboard', compact(
            'totalAdvertisers',
            'totalPublishers',
            'totalCampaigns',
            'pendingCampaigns',
            'totalWithdrawRequests',
            'balance'
        ));
    }
}
