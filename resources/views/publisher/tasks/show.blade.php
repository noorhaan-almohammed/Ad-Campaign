@extends('publisher.layout')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Task Details</h2>

    <div class="bg-white p-6 shadow-md rounded-xl">

        {{-- Basic Info --}}
        <div class="space-y-2 mb-6">
            <p><strong class="text-gray-700">Campaign:</strong> {{ $task->campaign->name }}</p>
            <p><strong class="text-gray-700">Description:</strong> {{ $task->campaign->description }}</p>
            <p><strong class="text-gray-700">Reward:</strong> ${{ $task->reward }}</p>
            <p>
                <strong class="text-gray-700">Status:</strong>
                <span
                    class="px-3 py-1 rounded text-black
                @if ($task->status == 'approved') bg-green-600
                @elseif($task->status == 'rejected') bg-red-600
                @else bg-yellow-500 @endif">
                    {{ ucfirst($task->status) }}
                </span>
            </p>
        </div>

        {{-- Show Proof Preview if exists --}}
        @if ($task->proof_file || $task->proof_link)
            <div class="bg-gray-50 p-4 rounded-lg mb-6 border">
                <h3 class="text-xl font-semibold mb-3">Submitted Proof</h3>

                {{-- File Preview --}}
                @if ($task->proof_file)
                    @php
                        $ext = pathinfo($task->proof_file, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $task->proof_file) }}" alt="Proof Image"
                            class="mt-2 rounded-lg border w-64 shadow">
                    @else
                        <a href="{{ asset('storage/' . $task->proof_file) }}" target="_blank"
                            class="text-blue-600 underline mt-2 block">
                            View Uploaded File
                        </a>
                    @endif
                @endif


                {{-- Link Preview --}}
                @if ($task->proof_link)
                    <div class="mt-2">
                        <strong>Proof Link:</strong><br>
                        <a href="{{ $task->proof_link }}" target="_blank" class="text-blue-600 underline">
                            {{ $task->proof_link }}
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Submit Form --}}
        @unless ($task->proof_file || $task->proof_link || $task->status == 'waiting_review')
            <hr class="my-6">

            <h3 class="text-2xl font-semibold mb-4">Submit Proof</h3>

            <form action="{{ route('publisher.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium mb-1">Upload File</label>
                    <input type="file" name="proof_file"
                        class="border p-2 w-full rounded focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block font-medium mb-1">Proof Link</label>
                    <input type="text" name="proof_link" placeholder="https://..."
                        class="border p-2 w-full rounded focus:ring focus:ring-blue-200">
                </div>

                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Submit Proof
                </button>
            </form>
        @endunless

    </div>
@endsection
