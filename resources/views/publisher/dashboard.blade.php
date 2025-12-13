@extends('publisher.layout')

@section('content')
<h2 class="text-2xl font-bold mb-4">Publisher Dashboard</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-3 gap-4">

    <!-- الرصيد -->
    <div class="bg-white shadow p-4 rounded">
        <h3 class="text-xl font-semibold">Wallet Balance</h3>
        <p class="text-3xl">{{ number_format($balance, 2) }}$</p>

        <button onclick="document.getElementById('withdrawModal').showModal()"
            class="mt-3 bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded">
            Request Withdrawal
        </button>
    </div>

    <div class="bg-white shadow p-4 rounded">
        <h3 class="text-xl font-semibold">Completed Tasks</h3>
        <p class="text-3xl">{{ $tasksCompleted }}</p>
    </div>

    <div class="bg-white shadow p-4 rounded">
        <h3 class="text-xl font-semibold">Pending Tasks</h3>
        <p class="text-3xl">{{ $tasksPending }}</p>
    </div>

</div>
{{-- جدول طلبات السحب --}}
<div class="bg-white shadow rounded p-4 mt-6">
    <h3 class="text-xl font-semibold mb-4">Withdrawal Requests</h3>

    @if($withdrawRequests->isEmpty())
        <p class="text-gray-600">No withdrawal requests yet.</p>
    @else
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Method</th>
                <th class="p-2 border">Account</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawRequests as $req)
                <tr>
                    <td class="p-2 border">{{ number_format($req->amount, 2) }}$</td>
                    <td class="p-2 border capitalize">{{ $req->method }}</td>
                    <td class="p-2 border">{{ $req->account }}</td>

                    <td class="p-2 border">
                        @if($req->status === 'pending')
                            <span class="text-yellow-600 font-semibold">Pending</span>
                        @elseif($req->status === 'approved')
                            <span class="text-green-600 font-semibold">Approved</span>
                        @else
                            <span class="text-red-600 font-semibold">Rejected</span>
                        @endif
                    </td>

                    <td class="p-2 border">
                        {{ $req->created_at->format('Y-m-d H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- مودال طلب السحب --}}
<dialog id="withdrawModal" class="p-6 rounded shadow-xl w-1/3">

    <h3 class="text-xl font-bold mb-4">Request Withdrawal</h3>

    <form method="POST" action="{{ route('publisher.withdraw.store') }}" class="space-y-3">
        @csrf

        <div>
            <label class="block font-semibold">Amount</label>
            <input type="number" step="0.01" name="amount" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Method</label>
            <select name="method" class="w-full border rounded p-2" required>
                <option value="">Select method</option>
                <option value="paypal">PayPal</option>
                <option value="bank">Bank Transfer</option>
                <option value="stc">STC Pay</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Account</label>
            <input type="text" name="account" class="w-full border rounded p-2" required>
        </div>

        <div class="flex justify-between mt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Submit Request
            </button>

            <button type="button"
                onclick="document.getElementById('withdrawModal').close()"
                class="bg-gray-500 text-white px-4 py-2 rounded">
                Cancel
            </button>
        </div>
    </form>

</dialog>

@endsection
