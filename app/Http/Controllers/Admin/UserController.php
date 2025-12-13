<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallet')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:advertiser,publisher,admin',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles($data['role']);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function edit_balance(User $user)
    {
        $role = $user->roles->first();
        $user = $user::with('wallet')->findOrFail($user->id);
        return view('admin.users.charge', compact('user', 'role'));
    }
    public function charge_balance(Request $request, User $user)
    {
        $data = $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
        ]);

        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = $user->wallet()->create(['balance' => 0, 'locked_balance' => 0]);
        }

        $wallet->balance += $data['amount'] ?? 0;
        $wallet->save();

        return back()->with('success', 'Balance filled successfully.');
    }
}
