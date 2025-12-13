@extends('advertiser.layout')

@section('content')

<div class="p-6 space-y-6 mb-10">

    {{-- الصفحة الرئيسية --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-green-900">Edit Campaign</h2>
        <a href="{{ route('advertiser.campaigns.index') }}"
           class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
            Back to Campaigns
        </a>
    </div>

    {{-- رسالة النجاح --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-4 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- النموذج --}}
    <form method="POST" action="{{ route('advertiser.campaigns.update', $campaign) }}"
          class="bg-white shadow-lg rounded-lg p-8 space-y-8" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- المعلومات الأساسية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $campaign->name) }}"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Budget (USD)</label>
                <input type="number" name="budget" step="0.01"
                       value="{{ old('budget', $campaign->budget) }}"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('budget') border-red-500 @enderror">
                @error('budget') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Start Date</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date', optional($campaign->start_date)->format('Y-m-d') ?? $campaign->start_date) }}"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('start_date') border-red-500 @enderror">
                @error('start_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">End Date</label>
                <input type="date" name="end_date"
                       value="{{ old('end_date', optional($campaign->end_date)->format('Y-m-d') ?? $campaign->end_date) }}"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('end_date') border-red-500 @enderror">
                @error('end_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- الوصف --}}
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('description') border-red-500 @enderror">{{ old('description', $campaign->description) }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Existing Media --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Existing Media</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($campaign->media as $media)
                    <div class="bg-gray-50 rounded-lg shadow p-2 relative flex flex-col items-center justify-center" id="media-item-{{ $media->id }}">
                        @if($media->type === 'image' && $media->file_path)
                            <img src="{{ asset('storage/'.$media->file_path) }}" alt="image" class="w-full h-32 object-cover rounded-lg">
                        @elseif($media->type === 'video' && $media->file_path)
                            <video src="{{ asset('storage/'.$media->file_path) }}" controls class="w-full h-32 object-cover rounded-lg"></video>
                        @elseif($media->type === 'file' && $media->file_path)
                            <a href="{{ asset('storage/'.$media->file_path) }}" target="_blank"
                               class="text-center text-sm truncate w-full">{{ basename($media->file_path) }}</a>
                        @elseif($media->type === 'link' && $media->url)
                            <a href="{{ $media->url }}" target="_blank" class="text-blue-600 underline text-sm break-all truncate w-full">{{ \Illuminate\Support\Str::limit($media->url, 35) }}</a>
                        @else
                            <span class="text-gray-400 text-sm">No preview</span>
                        @endif

                        <button type="button"
                                class="delete-media mt-2 text-red-600 text-sm hover:underline"
                                data-id="{{ $media->id }}"
                                data-delete-url="{{ route('advertiser.campaign.media.delete', $media) }}">
                            Delete
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Upload New Media --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Upload New Media</label>
            <input type="file" name="media_files[]" id="media_input" multiple
                   class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400 @error('media_files.*') border-red-500 @enderror">
            @error('media_files.*') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            <div id="preview_container" class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3"></div>
        </div>

        {{-- External Links --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">External Media Links</label>
            <div id="links_wrapper" class="space-y-2">
                @php $oldLinks = old('media_links') ?? ['']; @endphp
                @foreach($oldLinks as $link)
                    <div class="flex gap-2">
                        <input type="text" name="media_links[]" value="{{ $link }}" placeholder="https://example.com/ad"
                               class="w-full border p-2 rounded focus:ring-2 focus:ring-green-400">
                        <button type="button" class="px-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="this.parentElement.remove()">X</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addLinkField()"
                    class="mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                + Add Another Link
            </button>
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                Update Campaign
            </button>
        </div>
    </form>
</div>

<script>
    // Delete media via AJAX
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.delete-media')) return;
        const btn = e.target;
        const id = btn.dataset.id;
        const url = btn.dataset.deleteUrl;
        if (!confirm("Delete this file?")) return;

        fetch(url, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('media-item-' + id);
                if (el) el.remove();
            } else {
                alert(data.message || 'Delete failed');
            }
        })
        .catch(() => alert('Delete failed'));
    });

    // Preview new files
    document.getElementById('media_input').addEventListener('change', function(e) {
        let container = document.getElementById('preview_container');
        container.innerHTML = '';
        [...e.target.files].forEach(file => {
            let box = document.createElement('div');
            box.className = "w-full h-32 border rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center";
            let type = (file.type || '').split('/')[0];
            if(type==="image"){
                let img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = "w-full h-full object-cover";
                box.appendChild(img);
            } else if(type==="video"){
                let video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.className = "w-full h-full object-cover";
                box.appendChild(video);
            } else {
                let div = document.createElement('div');
                div.className = "text-sm text-gray-700 text-center px-2";
                div.innerText = file.name;
                box.appendChild(div);
            }
            container.appendChild(box);
        });
    });

    function addLinkField() {
        let wrapper = document.getElementById('links_wrapper');
        let row = document.createElement('div');
        row.className = "flex gap-2";
        row.innerHTML = `
            <input type="text" name="media_links[]" placeholder="https://example.com/ad"
                   class="w-full border p-2 rounded focus:ring-2 focus:ring-green-400">
            <button type="button" class="px-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="this.parentElement.remove()">X</button>
        `;
        wrapper.appendChild(row);
    }
</script>

@endsection
