@extends('admin.layouts.app')

@section('title','Settings')

@section('content')
<h1 class="text-2xl font-bold mb-6">Settings</h1>

<form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white shadow p-6 rounded">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-1">Platform Commission (%)</label>
        <input type="number" name="platform_commission" value="{{ old('platform_commission', $settings->platform_commission ?? 10) }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Publisher Commission (%)</label>
        <input type="number" name="publisher_commission" value="{{ old('publisher_commission', $settings->publisher_commission ?? 70) }}" class="w-full border p-2 rounded">
    </div>
    <div class="mb-4">
        <label class="block mb-1">Minimum Withdraw (%)</label>
        <input type="number" name="minimum_withdraw" value="{{ old('minimum_withdraw', $settings->minimum_withdraw ?? 50) }}" class="w-full border p-2 rounded">
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Settings</button>
</form>
@endsection
