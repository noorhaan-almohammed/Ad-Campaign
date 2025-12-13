<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WithdrawRequest;
use App\Models\Wallet;

class WithdrawController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
            'account' => 'required|string'
        ]);

        $wallet = Auth::user()->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        // إنشاء طلب سحب
        WithdrawRequest::create([
            'user_id' => Auth::id(),
            'amount' => $data['amount'],
            'method' => $data['method'],
            'account' => $data['account'],
            'status' => 'pending',
        ]);

        // خصم المبلغ من الرصيد + نقله للمبلغ المجمّد
        $wallet->balance -= $request->amount;
        $wallet->locked_balance += $request->amount;
        $wallet->save();

        return back()->with('success', 'Withdrawal request submitted successfully.');
    }
}
