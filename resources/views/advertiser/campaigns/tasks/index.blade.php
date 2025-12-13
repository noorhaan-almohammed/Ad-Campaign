@extends('advertiser.layout')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-green-900">
                Tasks Review
            </h2>
            <p class="text-gray-500 mt-1">
                Review publishers submissions for your campaigns
            </p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-green-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Campaign</th>
                        <th class="px-4 py-3 text-left">Task</th>
                        <th class="px-4 py-3 text-left">Publisher</th>
                        <th class="px-4 py-3 text-left">Reward</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($tasks as $task)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $task->campaign->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $task->task->title }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $task->publisher->name }}
                        </td>

                        <td class="px-4 py-3 font-semibold text-green-700">
                            {{ number_format($task->reward, 2) }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($task->status === 'approved') bg-green-200 text-green-700
                                @elseif($task->status === 'rejected') bg-red-200 text-red-700
                                @else bg-yellow-200 text-yellow-700 @endif">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('advertiser.tasks.review', $task->id) }}"
                               class="inline-flex items-center gap-2 px-4 py-1.5 text-sm font-medium
                                      text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                                Review
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            No tasks found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gray-50">
            {{ $tasks->links() }}
        </div>

    </div>
</div>

@endsection
