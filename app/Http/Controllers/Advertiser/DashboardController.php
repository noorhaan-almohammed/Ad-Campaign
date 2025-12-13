<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $transactions = $user->transactions()
            ->latest()
            ->paginate(10);

        return view('advertiser.dashboard.index', [
            'campaigns_count' => Campaign::where('user_id', $user->id)->count(),
            'active_campaigns' => Campaign::where('user_id', $user->id)->where('status', 'approved')->count(),
            'invoices_count' => Invoice::where('user_id', $user->id)->count(),
            'transactions' => $transactions,
        ]);
    }
}
