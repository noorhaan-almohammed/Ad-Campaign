@extends('publisher.layout')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Publisher Profile</h2>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile Information --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Personal Info</h3>

            <form action="{{ route('publisher.profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="font-medium">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="font-medium">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </form>
        </div>

        {{-- Wallet --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Wallet</h3>

            <p class="text-lg"><strong>Balance:</strong> ${{ number_format($wallet->balance, 2) }}</p>
            <p class="text-lg mt-2"><strong>Locked Balance:</strong> ${{ number_format($wallet->locked_balance, 2) }}</p>
        </div>

        {{-- Password Update --}}
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Change Password</h3>

            <form action="{{ route('publisher.profile.password') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="font-medium">Current Password</label>
                    <input type="password" name="current_password" class="w-full border rounded p-2">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="font-medium">New Password</label>
                    <input type="password" name="password" class="w-full border rounded p-2">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded p-2">
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    Update Password
                </button>
            </form>
        </div>

    </div>

    {{-- Publisher Tasks --}}
    <div class="bg-white p-6 rounded-xl shadow mt-8">
        <h3 class="text-2xl font-semibold mb-4">My Completed Tasks</h3>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Campaign</th>
                    <th class="p-2 border">Reward</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Submitted At</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td class="p-2 border">{{ $task->campaign->name }}</td>
                        <td class="p-2 border text-green-600">${{ $task->reward }}</td>
                        <td class="p-2 border">
                            <span class="px-2 py-1 rounded bg-gray-200">{{ ucfirst($task->status) }}</span>
                        </td>
                        <td class="p-2 border">{{ $task->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $tasks->links() }}</div>
    </div>

    {{-- Transactions --}}
    <div class="bg-white p-6 rounded-xl shadow mt-8">
        <h3 class="text-2xl font-semibold mb-4">Transaction History</h3>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Amount</th>
                    <th class="p-2 border">Reference</th>
                    <th class="p-2 border">Notes</th>
                    <th class="p-2 border">Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($transactions as $t)
                    <tr>
                        <td class="p-2 border">{{ ucfirst($t->type) }}</td>

                        <td class="p-2 border">
                            @if ($t->amount > 0)
                                <span class="text-green-600">+{{ $t->amount }} $</span>
                            @else
                                <span class="text-red-600">{{ $t->amount }} $</span>
                            @endif
                        </td>

                        <td class="p-2 border">{{ $t->reference ?? '-' }}</td>
                        <td class="p-2 border">{{ $t->notes ?? '-' }}</td>
                        <td class="p-2 border">{{ $t->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $transactions->links() }}</div>
    </div>
@endsection
