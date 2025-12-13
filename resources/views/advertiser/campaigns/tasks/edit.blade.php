@extends('advertiser.layout')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-green-900">
            Edit Campaign Tasks
        </h2>
        <p class="text-gray-500 mt-1">
            Campaign:
            <span class="font-semibold text-gray-700">
                {{ $campaign->name }}
            </span>
        </p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Form --}}
    <form method="POST"
          action="{{ route('advertiser.campaigns.tasks.update', $campaign->id) }}"
          class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        @csrf

        {{-- Tasks Wrapper --}}
        <div id="tasks_wrapper" class="space-y-6">

            @foreach($campaign->tasks as $task)
            <div class="task-box bg-gray-50 border rounded-xl p-6 relative">

                <input type="hidden"
                       name="tasks[{{ $loop->index }}][id]"
                       value="{{ $task->id }}">

                {{-- Task Header --}}
                <div class="flex justify-between items-center mb-5">
                    <h4 class="text-lg font-semibold text-gray-800">
                        Task #{{ $loop->iteration }}
                    </h4>

                    <button type="button"
                            onclick="this.closest('.task-box').remove()"
                            class="text-red-600 hover:text-red-800 font-bold text-xl">
                        X
                    </button>
                </div>

                {{-- Task Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Task Title
                        </label>
                        <input type="text"
                               name="tasks[{{ $loop->index }}][title]"
                               value="{{ $task->title }}"
                               class="w-full border rounded-lg p-2.5  focus:ring-0 focus:border-green-600"
                               placeholder="Task title">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Reward
                        </label>
                        <input type="number"
                               step="0.01"
                               name="tasks[{{ $loop->index }}][reward]"
                               value="{{ $task->reward }}"
                               class="w-full border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                               placeholder="Reward amount">
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Description
                    </label>
                    <textarea name="tasks[{{ $loop->index }}][description]"
                              rows="3"
                              class="w-full border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                              placeholder="Task description">{{ $task->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Max Completions
                        </label>
                        <input type="number"
                               name="tasks[{{ $loop->index }}][max_completions]"
                               value="{{ $task->max_completions }}"
                               class="w-full border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                               placeholder="Max completions">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Status
                        </label>
                        <select name="tasks[{{ $loop->index }}][status]"
                                class="w-full border rounded-lg p-2.5">
                            <option value="active" {{ $task->status === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="paused" {{ $task->status === 'paused' ? 'selected' : '' }}>
                                Paused
                            </option>
                        </select>
                    </div>

                </div>
            </div>
            @endforeach

        </div>

        {{-- Add Task Button --}}
        <button type="button"
                onclick="addTaskField()"
                class="w-full py-3 border-2 border-dashed border-green-400 text-green-700 rounded-xl hover:bg-green-50 transition font-semibold">
            + Add New Task
        </button>

        {{-- Form Footer --}}
        <div class="flex justify-end gap-4 pt-6 border-t mt-6">

            <a href="{{ route('advertiser.campaigns.index') }}"
               class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                Cancel
            </a>

            <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Save All Tasks
            </button>

        </div>

    </form>
</div>

{{-- Script --}}
<script>
    function addTaskField() {
        const wrapper = document.getElementById('tasks_wrapper');
        const index = wrapper.children.length;

        const box = document.createElement('div');
        box.className = "task-box bg-gray-50 border rounded-xl p-6 relative";

        box.innerHTML = `
            <div class="flex justify-between items-center mb-5">
                <h4 class="text-lg font-semibold text-gray-800">
                    New Task
                </h4>
                <button type="button"
                        onclick="this.closest('.task-box').remove()"
                        class="text-red-600 hover:text-red-800 font-bold text-xl">
                    x
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text"
                       name="tasks[${index}][title]"
                       class="border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                       placeholder="Task title">

                <input type="number"
                       step="0.01"
                       name="tasks[${index}][reward]"
                       class="border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                       placeholder="Reward">
            </div>

            <textarea name="tasks[${index}][description]"
                      rows="3"
                      class="mt-4 w-full border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                      placeholder="Task description"></textarea>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <input type="number"
                       name="tasks[${index}][max_completions]"
                       class="border rounded-lg p-2.5 focus:ring-0 focus:border-green-600"
                       placeholder="Max completions">

                <select name="tasks[${index}][status]"
                        class="border rounded-lg p-2.5 focus:ring-0 focus:border-green-600">
                    <option value="active">Active</option>
                    <option value="paused">Paused</option>
                </select>
            </div>
        `;

        wrapper.appendChild(box);
    }
</script>

@endsection
