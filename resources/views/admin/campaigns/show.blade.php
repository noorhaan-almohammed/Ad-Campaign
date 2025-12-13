@extends('admin.layouts.app')

@section('title','Campaign Details')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">{{ $campaign->name }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><span class="font-semibold">Advertiser:</span> {{ $campaign->user->name }}</p>
            <p><span class="font-semibold">Budget:</span> ${{ number_format($campaign->budget, 2) }}</p>
            <p><span class="font-semibold">Remaining Budget:</span> ${{ number_format($campaign->remaining_budget, 2) }}</p>
            <p>
                <span class="font-semibold">Status:</span>
                <span class="px-2 py-1 rounded-full text-white
                    {{ $campaign->status === 'approved' ? 'bg-green-500' : ($campaign->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                    {{ ucfirst($campaign->status) }}
                </span>
            </p>
            <p><span class="font-semibold">Start Date:</span> {{ $campaign->start_date }}</p>
            <p><span class="font-semibold">End Date:</span> {{ $campaign->end_date }}</p>
        </div>

        <div class="mt-4">
            <h3 class="text-xl font-semibold mb-2">Description</h3>
            <p class="text-gray-700">{{ $campaign->description }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-xl font-semibold mb-2">Media</h3>
        <div class="flex flex-wrap gap-4">
            @foreach($campaign->media as $media)
                <div class="w-32 h-32 border rounded overflow-hidden flex items-center justify-center bg-gray-50">
                    @if($media->type === 'image')
                        <img src="{{ asset('storage/'.$media->file_path) }}" class="w-full h-full object-cover">
                    @elseif($media->type === 'video')
                        <video src="{{ asset('storage/'.$media->file_path) }}" class="w-full h-full" controls></video>
                    @elseif($media->type === 'file')
                        <a href="{{ asset('storage/'.$media->file_path) }}" target="_blank" class="block bg-gray-200 p-2 rounded text-center text-sm">
                            Download File
                        </a>
                    @elseif($media->type === 'link')
                        <a href="{{ $media->url }}" target="_blank" class="block text-blue-600 underline text-sm text-center">
                            Visit Link
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('admin.campaigns.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Back to Campaigns
    </a>
</div>
@endsection
