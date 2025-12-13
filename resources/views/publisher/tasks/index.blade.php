@extends('publisher.layout')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Available Tasks</h2>

    <table class="w-full bg-white shadow">
        <thead>
            <tr>
                <th class="p-2 border">Campaign</th>
                <th class="p-2 border">Title</th>

                <th class="p-2 border">Reward</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td class="p-2 border">{{ $task->campaign->name }}</td>
                    <td class="p-2 border">{{ $task->task->title }}</td>
                    <td class="p-2 border">{{ $task->reward }}</td>
                    <td class="p-3 border text-white">
                        <span class="px-3 py-1 rounded-xl text-center
                        @if ($task->status == 'approved') bg-green-600
                        @elseif($task->status == 'rejected') bg-red-600
                        @elseif($task->status == 'waiting_review') bg-yellow-600
                        @else bg-blue-500 @endif">
                         {{ ucfirst($task->status) }}
                    </span>
                </td>
                    <td class="p-2 border">
                        <a href="{{ route('publisher.tasks.show', $task->id) }}" class="text-blue-600">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tasks->links() }}
@endsection
