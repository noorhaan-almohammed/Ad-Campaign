@extends('publisher.layout')

@section('title', 'Campaigns')

@section('content')

<h2 class="text-2xl font-bold mb-4">Available Campaigns</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach ($campaigns as $campaign)
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-xl font-semibold">{{ $campaign->name }}</h3>
            <p class="text-gray-600">{{ Str::limit($campaign->description, 100) }}</p>
            <p class="mt-2 font-bold text-green-700">Reward Range: ${{ $campaign->tasks->min('reward') }} - ${{ $campaign->tasks->max('reward') }}</p>
            <p class="mt-1 text-sm text-gray-500">Remaining Budget: ${{ $campaign->remaining_budget }}</p>
            <p class="mt-1 text-sm text-gray-500">Status: {{ ucfirst($campaign->status) }}</p>
            <p class="mt-1 text-sm text-gray-500">Duration: {{ $campaign->start_date }} to {{ $campaign->end_date }}</p>
            <p class="mt-1 text-sm text-gray-500">Total Tasks: {{ $campaign->tasks->count() }}</p>
            <p class="mt-1 text-sm text-gray-500">Available Tasks: {{ $campaign->tasks->where('reward', '<=', $campaign->remaining_budget)->count() }}</p>

            <a href="{{ route('publisher.campaigns.show', $campaign->id) }}"
               class="text-blue-600 mt-3 inline-block">View Tasks →</a>
        </div>
    @endforeach
</div>

{{ $campaigns->links() }}

@endsection
