<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\WithdrawRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WithdrawRequestController extends Controller
{
    public function index()
    {
        // الطلبات المعلقة
        $pending = WithdrawRequest::where('status', 'pending')->latest()->get();

        // كل الطلبات
        $all = WithdrawRequest::latest()->paginate(15);

        // رصيد الأدمن
        $admin = User::where('id', 1)->first(); // عدل حسب إدارتك
        $adminBalance = $admin?->wallet?->balance ?? 0;

        return view('admin.withdraw.index', compact('pending', 'all', 'adminBalance'));
    }

    public function approve(WithdrawRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = $request->user;
            $wallet = $user->wallet;

            $admin = User::where('id', 1)->first();
            $adminWallet = $admin->wallet;

            // تحقق أن رصيد الادمن يسمح بالسحب
            if ($adminWallet->balance < $request->amount) {
                return back()->with('error', 'Admin wallet does not have enough balance.');
            }

            // إنقاص المبلغ من locked_balance للناشر
            $wallet->locked_balance -= $request->amount;
            $wallet->save();

            // إنقاص المبلغ من رصيد الأدمن
            $adminWallet->balance -= $request->amount;
            $adminWallet->save();

            // تغيير حالة الطلب
            $request->update(['status' => 'approved']);

            // تسجيل العملية في Transaction
            Transaction::create([
                'user_id' => $user->id,
                'type'    => 'withdraw',
                'amount'  => -$request->amount,
                'reference' => 'withdraw_request_' . $request->id,
                'notes'   => 'Withdrawal approved by admin'
            ]);
            Invoice::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'debit',
                'description' => 'Withdrawal approved: Request #' . $request->id,
            ]);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            logger()->error('Error approving withdrawal request: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while approving the withdrawal request: ' . $e->getMessage());
        }

        return back()->with('success', 'Withdrawal request approved successfully.');
    }

    public function reject(WithdrawRequest $request)
    {
        DB::transaction(function () use ($request) {

            $user = $request->user;
            $wallet = $user->wallet;

            // إعادة locked_balance إلى الرصيد العادي
            $wallet->balance += $request->amount;
            $wallet->locked_balance -= $request->amount;
            $wallet->save();

            // تغيير حالة الطلب
            $request->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Withdrawal request rejected.');
    }
}
