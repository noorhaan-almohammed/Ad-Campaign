@extends('advertiser.layout')

@section('content')
    <div class="max-w-6xl mx-auto mb-20">

        {{-- Page Header --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Create New Campaign</h2>
            <p class="text-gray-500 mt-1">
                Set up your campaign details, media, and tasks in one place
            </p>
        </div>
        <form method="POST" action="{{ route('advertiser.campaigns.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    📌 Campaign Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Campaign Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border rounded-lg p-2.5 focus:ring focus:ring-green-200">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Budget --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Budget (USD)</label>
                        <input type="number" step="0.01" name="budget" value="{{ old('budget') }}"
                            class="w-full border rounded-lg p-2.5 focus:ring focus:ring-green-200">
                        @error('budget')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-green-200">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" name="start_date" class="w-full border rounded-lg p-2.5">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" name="end_date" class="w-full border rounded-lg p-2.5">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    🖼 Media & Assets
                </h3>

                <input type="file" name="media_files[]" multiple id="media_input"
                    class="w-full border rounded-lg p-2 bg-gray-50">
                @error('media_files.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div id="preview_container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    🔗 External Media Links
                </h3>

                <div id="links_wrapper" class="space-y-2">
                    <div class="flex gap-2">
                        <input type="text" name="media_links[]" class="w-full border rounded-lg p-2"
                            placeholder="https://example.com/ad">
                        @error('media_links.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <button type="button" class="px-3 bg-red-500 text-white rounded-lg"
                            onclick="this.parentElement.remove()">✕</button>
                    </div>
                </div>

                <button type="button" onclick="addLinkField()"
                    class="mt-3 text-sm text-green-700 font-medium hover:underline">
                    + Add another link
                </button>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    🧩 Campaign Tasks
                </h3>

                <div id="tasks_wrapper" class="space-y-4"></div>

                <button type="button" onclick="addTaskField()"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Add Task
                </button>
                @error('tasks')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>
            <div class="flex justify-end gap-4">
                <a href="{{ route('advertiser.campaigns.index') }}"
                    class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>

                <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Create Campaign
                </button>
            </div>

        </form>
    </div>
    {{-- PREVIEW SCRIPT --}}
    <script>
        document.getElementById('media_input').addEventListener('change', function(e) {
            const container = document.getElementById('preview_container');
            container.innerHTML = '';

            [...e.target.files].forEach(file => {
                let wrapper = document.createElement('div');
                wrapper.className = "border p-2 rounded shadow-sm bg-gray-100";

                if (file.type.startsWith("image/")) {
                    let img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = "w-full h-32 object-cover rounded";
                    wrapper.appendChild(img);
                } else if (file.type.startsWith("video/")) {
                    let video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.className = "w-full h-32 object-cover rounded";
                    wrapper.appendChild(video);
                } else {
                    let div = document.createElement('div');
                    div.innerHTML = `
                        <div class="text-center text-gray-700 text-sm">
                            <p class="font-semibold">File</p>
                            <p>${file.name}</p>
                        </div>
                    `;
                    wrapper.appendChild(div);
                }

                container.appendChild(wrapper);
            });
        });

        function addLinkField() {
            let wrapper = document.getElementById('links_wrapper');

            let row = document.createElement('div');
            row.className = "flex gap-2 mb-2";

            row.innerHTML = `
                <input type="string" name="media_links[]"
                       placeholder="https://example.com/ad"
                       class="w-full border p-2 rounded">

                <button type="button"
                        class="px-2 bg-red-600 text-white rounded"
                        onclick="this.parentElement.remove()">X</button>
            `;

            wrapper.appendChild(row);
        }

        function addTaskField() {
            const wrapper = document.getElementById('tasks_wrapper');
            const index = wrapper.children.length;

            let box = document.createElement('div');
            box.className = "border p-4 rounded mb-4 bg-gray-50 task-box";

            box.innerHTML = `
        <div class="flex justify-between mb-3">
            <h4 class="font-semibold">Task</h4>
            <button type="button"
                    onclick="this.closest('.task-box').remove()"
                    class="px-2 bg-red-600 text-white rounded">
                X
            </button>
        </div>

        <input type="text" name="tasks[${index}][title]"
               class="w-full border p-2 rounded mb-2"
               placeholder="Task Title">

        <textarea name="tasks[${index}][description]"
                  rows="2"
                  class="w-full border p-2 rounded mb-2"
                  placeholder="Task Description"></textarea>

        <div class="flex gap-4 mb-2">
            <input type="number" step="0.01"
                   name="tasks[${index}][reward]"
                   class="w-full border p-2 rounded"
                   placeholder="Reward">

            <input type="number"
                   name="tasks[${index}][max_completions]"
                   class="w-full border p-2 rounded"
                   placeholder="Max Completions">
        </div>

        <select name="tasks[${index}][status]"
                class="border p-2 rounded w-full">
            <option value="active">Active</option>
            <option value="paused">Paused</option>
        </select>
    `;

            wrapper.appendChild(box);
        }
    </script>
@endsection
