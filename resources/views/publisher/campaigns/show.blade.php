@use('App\Models\PublisherTask')
@extends('publisher.layout')

@section('title', $campaign->name)

@section('content')

    <p class="text-gray-700 mb-6">{{ $campaign->description }}</p>
    {{-- عرض الصور الخاصة بالحملة --}}
    @if($campaign->media->isNotEmpty())
        <div class="flex flex-wrap gap-4 mb-6">
            @foreach($campaign->media as $media)
                <div class="w-32 h-32">
                    @if($media->type === 'image')
                        <img src="{{ asset('storage/'.$media->file_path) }}" class="w-full h-full object-cover rounded">
                    @elseif($media->type === 'video')
                        <video src="{{ asset('storage/'.$media->file_path) }}" class="w-full h-full rounded" controls></video>
                    @elseif($media->type === 'file')
                        <a href="{{ asset('storage/'.$media->file_path) }}" target="_blank" class="block bg-gray-200 p-3 rounded text-center">File</a>
                    @elseif($media->type === 'link')
                        <a href="{{ $media->url }}" target="_blank" class="block text-blue-600 underline">Link</a>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    <h3 class="text-xl font-semibold mb-3">Tasks</h3>

    @foreach ($tasks as $task)
        <div class="bg-white p-4 shadow rounded mb-4">
            <h4 class="text-lg font-semibold">{{ $task->title }}</h4>
            <p class="text-gray-600">{{ $task->description }}</p>

            <div class="flex justify-between items-center mt-3">
                <span class="font-bold text-green-700">${{ $task->reward }}</span>

                <form action="{{ route('publisher.tasks.execute', $task->id) }}" method="POST">
                    @csrf
                    @if (!PublisherTask::where('publisher_id', Auth::id())
                                      ->where('campaign_task_id', $task->id)->exists())
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Execute Task</button>
                    @endif

                </form>
            </div>
        </div>
    @endforeach

@endsection
