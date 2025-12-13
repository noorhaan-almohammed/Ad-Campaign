
@extends('admin.layouts.app')

@section('title', 'Withdraw Requests')

@section('content')

<h2 class="text-2xl font-bold mb-6">Withdraw Requests</h2>

{{-- رصيد الادمن --}}
<div class="bg-white p-4 rounded shadow mb-6">
    <p class="text-lg font-semibold">Admin Wallet Balance:</p>
    <p class="text-2xl font-bold text-green-600">{{ number_format($adminBalance, 2) }}$</p>
</div>

{{-- الطلبات المعلقة --}}
<div class="bg-white p-4 rounded shadow mb-6">
    <h3 class="text-xl font-semibold mb-3">Pending Requests</h3>

    @if($pending->isEmpty())
        <p class="text-gray-500">No pending requests.</p>
    @else
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">User</th>
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Method</th>
                <th class="p-2 border">Account</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending as $req)
                <tr>
                    <td class="border p-2">{{ $req->user->name }}</td>
                    <td class="border p-2">{{ number_format($req->amount,2) }}$</td>
                    <td class="border p-2">{{ $req->method }}</td>
                    <td class="border p-2">{{ $req->account }}</td>

                    <td class="border p-2 flex gap-2">
                        <form action="{{ route('admin.withdraw.approve', $req->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                        </form>

                        <form action="{{ route('admin.withdraw.reject', $req->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- كل الطلبات --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="text-xl font-semibold mb-3">All Withdraw Requests</h3>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">User</th>
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Method</th>
                <th class="p-2 border">Account</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all as $req)
                <tr>
                    <td class="border p-2">{{ $req->user->name }}</td>
                    <td class="border p-2">{{ number_format($req->amount,2) }}$</td>
                    <td class="border p-2">
                        @if($req->status === 'pending')
                            <span class="text-yellow-600 font-semibold">Pending</span>
                        @elseif($req->status === 'approved')
                            <span class="text-green-600 font-semibold">Approved</span>
                        @else
                            <span class="text-red-600 font-semibold">Rejected</span>
                        @endif
                    </td>
                    <td class="border p-2">{{ $req->method }}</td>
                    <td class="border p-2">{{ $req->account }}</td>
                    <td class="border p-2">{{ $req->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $all->links() }}
    </div>
</div>

@endsection
