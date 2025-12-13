@extends('advertiser.layout')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Advertiser Profile</h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile Info --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Personal Information</h3>

            <form action="{{ route('advertiser.profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2 focus:ring-0 focus:border-green-600">
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2 focus:ring-0 focus:border-green-600">
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Save Changes
                </button>
            </form>
        </div>


        {{-- Wallet Info --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Wallet</h3>

            <p class="text-lg">
                <strong>Balance:</strong> ${{ number_format($wallet->balance, 2) }}
            </p>

            <p class="text-lg mt-2">
                <strong>Locked Balance:</strong> ${{ number_format($wallet->locked_balance, 2) }}
            </p>
        </div>


        {{-- Update Password --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Change Password</h3>

            <form action="{{ route('advertiser.profile.password') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-gray-700 font-medium">Current Password</label>
                    <input type="password" name="current_password" class="w-full border rounded p-2 focus:ring-0 focus:border-green-600">
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-medium">New Password</label>
                    <input type="password" name="password" class="w-full border rounded p-2  focus:ring-0 focus:border-green-600">
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded p-2  focus:ring-0 focus:border-green-600">
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Update Password
                </button>
            </form>
        </div>

    </div>

@endsection
