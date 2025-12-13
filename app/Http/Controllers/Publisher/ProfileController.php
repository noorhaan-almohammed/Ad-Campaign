<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $wallet = $user->wallet;

        // Only publisher's own transactions
        $transactions = $user->transactions()
            ->latest()
            ->paginate(10);

        // Publisher tasks
        $tasks = $user->publisherTasks()
            ->with('campaign')
            ->latest()
            ->paginate(10);

        return view('publisher.profile.index', compact('user', 'wallet', 'transactions', 'tasks'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        /**
         * @var \App\Models\User $user
         */

        $user = Auth::user();
        $user->update($request->only('name', 'email'));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
