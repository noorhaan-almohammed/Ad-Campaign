@extends('publisher.layout')

@section('title', 'Earnings History')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Earnings Summary</h2>

    <div class="bg-green-100 p-4 rounded mb-6">
        <p class="text-lg font-semibold">
            Total Earnings:
            <span class="text-green-700 text-2xl">{{ $total }}$</span>
        </p>
    </div>

    <h3 class="text-lg font-bold mb-3">Earnings History</h3>

    <table class="w-full border bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Task ID</th>
                <th class="p-2 border">Campaign</th>
                <th class="p-2 border">Reward</th>
                <th class="p-2 border">Completed At</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($earnings as $item)
                <tr>
                    <td class="p-2 border">{{ $item->id }}</td>
                    <td class="p-2 border">{{ $item->campaign->name }}</td>
                    <td class="p-2 border">{{ $item->reward }}$</td>
                    <td class="p-2 border">{{ $item->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $earnings->links() }}
    </div>

</div>

@endsection
