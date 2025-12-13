@extends('admin.layouts.app')

@section('title','Campaigns')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Campaigns</h1>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Advertiser</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Budget</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Remaining Budget</th>
                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $campaign->id }}</td>
                        <td class="px-4 py-2 text-sm">{{ $campaign->name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $campaign->user->name }}</td>
                        <td class="px-4 py-2 text-sm text-right">$ {{ number_format($campaign->budget, 2) }}</td>
                        <td class="px-4 py-2 text-sm text-right">$ {{ number_format($campaign->remaining_budget, 2) }}</td>
                        <td class="px-4 py-2 text-center text-sm">
                            <span class="px-2 py-1 rounded-full text-white
                                {{ $campaign->status === 'approved' ? 'bg-green-500' : ($campaign->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-sm flex flex-wrap justify-center gap-2">
                            <a href="{{ route('admin.campaigns.show', $campaign) }}" class="text-blue-600 hover:underline">View</a>

                            @if($campaign->status === 'pending')
                                <form action="{{ route('admin.campaigns.approve', $campaign) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Approve</button>
                                </form>
                                <form action="{{ route('admin.campaigns.reject', $campaign) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Reject</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-800 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection
