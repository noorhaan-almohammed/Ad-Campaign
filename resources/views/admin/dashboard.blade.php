@extends('admin.layouts.app')

@section('title','Dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6 text-gray-800">Dashboard Overview</h1>

{{-- Top Stats --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- Advertisers --}}
    <div class="bg-white shadow p-5 rounded-lg border border-gray-200 flex items-center gap-4">
        <div class="bg-blue-100 text-blue-700 p-3 rounded-full text-xl">📢</div>
        <div>
            <p class="text-gray-500 text-sm">Advertisers</p>
            <h3 class="text-xl font-bold text-gray-900">{{ $totalAdvertisers ?? 0 }}</h3>
        </div>
    </div>

    {{-- Publishers --}}
    <div class="bg-white shadow p-5 rounded-lg border border-gray-200 flex items-center gap-4">
        <div class="bg-green-100 text-green-700 p-3 rounded-full text-xl">👤</div>
        <div>
            <p class="text-gray-500 text-sm">Publishers</p>
            <h3 class="text-xl font-bold text-gray-900">{{ $totalPublishers ?? 0 }}</h3>
        </div>
    </div>

    {{-- Campaigns --}}
    <div class="bg-white shadow p-5 rounded-lg border border-gray-200 flex items-center gap-4">
        <div class="bg-yellow-100 text-yellow-700 p-3 rounded-full text-xl">📊</div>
        <div>
            <p class="text-gray-500 text-sm">Active Campaigns</p>
            <h3 class="text-xl font-bold text-gray-900">{{ $totalCampaigns ?? 0 }}</h3>
        </div>
    </div>

    {{-- Pending Campaigns --}}
    <div class="bg-white shadow p-5 rounded-lg border border-gray-200 flex items-center gap-4">
        <div class="bg-red-100 text-red-700 p-3 rounded-full text-xl">⏳</div>
        <div>
            <p class="text-gray-500 text-sm">Pending</p>
            <h3 class="text-xl font-bold text-gray-900">{{ $pendingCampaigns ?? 0 }}</h3>
        </div>
    </div>

</div>

{{-- Financial Info --}}
<div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Revenue --}}
    <div class="bg-white shadow p-6 rounded-lg border border-gray-200">
        <h4 class="text-gray-600 text-sm mb-1">Wallet Balance</h4>
        <p class="text-3xl font-bold text-gray-800">
            ${{ number_format($balance ?? 0, 2) }}
        </p>
    </div>

    {{-- Withdraw requests --}}
    <div class="bg-white shadow p-6 rounded-lg border border-gray-200">
        <h4 class="text-gray-600 text-sm mb-1">Withdraw Requests</h4>
        <p class="text-3xl font-bold text-gray-800">
            {{ $totalWithdrawRequests ?? 0 }}
        </p>
    </div>

</div>

@endsection
