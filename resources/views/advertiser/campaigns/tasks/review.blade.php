@extends('advertiser.layout')

@section('content')

<div class="max-w-5xl mx-auto mb-20">

    {{-- Header --}}
    <div class="mb-6 flex justify-between items-center">
      <div>
          <h2 class="text-3xl font-bold text-green-900">Review Task</h2>
        <p class="text-gray-500 mt-1">
            Review publisher submission and take action
        </p>
      </div>
      <div>
            <a href="{{ route('advertiser.tasks.index') }}"
                 class="inline-flex items-center gap-2 px-4 py-1.5 text-sm font-medium
                        text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition mt-4 md:mt-0">
                Back to Tasks
            </a>
      </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-lg ">

        {{-- Info Section --}}
        <div class="p-6 border-b grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Campaign Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Campaign Information</h3>

                <ul class="space-y-2 text-sm">
                    <li>
                        <span class="text-gray-500">Campaign ID:</span>
                        <span class="font-medium text-gray-900">CAM-{{ $task->campaign_id }}</span>
                    </li>
                    <li>
                        <span class="text-gray-500">Campaign Name:</span>
                        <span class="font-medium text-gray-900">{{ $task->campaign->name }}</span>
                    </li>
                    <li>
                        <span class="text-gray-500">Description:</span>
                        <p class="text-gray-800 mt-1">
                            {{ $task->campaign->description }}
                        </p>
                    </li>
                </ul>
            </div>

            {{-- Publisher Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Publisher Information</h3>

                <ul class="space-y-2 text-sm">
                    <li>
                        <span class="text-gray-500">Publisher ID:</span>
                        <span class="font-medium text-gray-900">PUB-{{ $task->publisher_id }}</span>
                    </li>
                    <li>
                        <span class="text-gray-500">Publisher Name:</span>
                        <span class="font-medium text-gray-900">{{ $task->publisher->name }}</span>
                    </li>
                    <li>
                        <span class="text-gray-500">Reward:</span>
                        <span class="font-semibold text-green-700">
                            ${{ number_format($task->reward, 2) }}
                        </span>
                    </li>
                    <li>
                        <span class="text-gray-500">Status:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if($task->status === 'approved') bg-green-100 text-green-700
                            @elseif($task->status === 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Proof Section --}}
        <div class="p-6 bg-gray-50 border-b">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Submitted Proof
            </h3>

            @if ($task->proof_file || $task->proof_link)
                <div class="flex flex-col gap-4">

                    {{-- File Proof --}}
                    @if ($task->proof_file)
                        @php
                            $ext = strtolower(pathinfo($task->proof_file, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Uploaded Image</p>
                                <img src="{{ asset('storage/' . $task->proof_file) }}"
                                     class="max-w-sm rounded-xl border shadow hover:shadow-lg transition">
                            </div>
                        @else
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Uploaded File</p>
                                <a href="{{ asset('storage/' . $task->proof_file) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline">
                                    View File
                                </a>
                            </div>
                        @endif
                    @endif

                    {{-- Link Proof --}}
                    @if ($task->proof_link)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Proof Link</p>
                            <a href="{{ $task->proof_link }}"
                               target="_blank"
                               class="text-blue-600 font-medium hover:underline break-all">
                                {{ $task->proof_link }}
                            </a>
                        </div>
                    @endif

                </div>
            @else
                <p class="text-gray-500 text-sm">No proof submitted.</p>
            @endif
        </div>

        {{-- Actions --}}
        @unless($task->status === 'approved' || $task->status === 'rejected')
        <div class="p-6 flex flex-col sm:flex-row gap-4">

            <form action="{{ route('advertiser.tasks.approve', $task->id) }}" method="POST">
                @csrf
                <button
                    class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-green-600 text-white font-medium
                           hover:bg-green-700 transition">
                    Approve Task
                </button>
            </form>

            <form action="{{ route('advertiser.tasks.reject', $task->id) }}" method="POST">
                @csrf
                <button
                    class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-red-600 text-white font-medium
                           hover:bg-red-700 transition">
                    Reject Task
                </button>
            </form>

        </div>
        @endunless

    </div>

</div>

@endsection
