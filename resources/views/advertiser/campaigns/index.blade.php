@extends('advertiser.layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-green-900">Your Campaigns</h2>

        <a href="{{ route('advertiser.campaigns.create') }}"
            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
            Create Campaign
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Budget</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Remaining Budget</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($campaigns as $campaign)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-6 py-4 text-gray-800">{{ $campaign->name }}</td>
                        <td class="px-6 py-4 text-gray-800">${{ number_format($campaign->budget, 2) }}</td>
                        <td class="px-6 py-4 text-gray-800">${{ number_format($campaign->remaining_budget, 2) }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if ($campaign->status === 'approved') bg-green-600 text-white
                        @elseif ($campaign->status === 'pending') bg-yellow-500 text-white
                        @else bg-red-600 text-white
                        @endif ">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-3 text-sm">
                            <a href="{{ route('advertiser.campaigns.edit', $campaign) }}"
                                class="text-green-50 text-base py-1 px-6 bg-green-700 rounded-full hover:bg-green-600 font-normal">Edit</a>
                            <a href="{{ route('advertiser.campaigns.tasks.edit', $campaign) }}"
                                class="text-green-600 hover:underline font-medium text-base">Tasks</a>
                            <form class="inline" method="POST"
                                action="{{ route('advertiser.campaigns.destroy', $campaign) }}">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline font-medium text-base"
                                    onclick="return confirm('Delete this campaign?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            No campaigns found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6 px-6 py-4">
            {{ $campaigns->links() }}
        </div>
    </div>
@endsection
