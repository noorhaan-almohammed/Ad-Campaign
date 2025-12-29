<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
            'role' => 'required|in:advertiser,publisher',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['role']);
        $user->wallet()->create();

        event(new Registered($user));

        Auth::login($user);

        /** @var \App\Models\User $user */

        $user = Auth::user();

        if ($user->hasRole('advertiser')) {
            return redirect('/advertiser/dashboard');
        } elseif ($user->hasRole('publisher')) {
            return redirect('/publisher/dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }

        return redirect('/');
    }
}
