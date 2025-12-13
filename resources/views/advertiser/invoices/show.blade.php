@extends('advertiser.layout')

@section('title', 'Invoice Details')

@section('content')
<div class="p-6">

    <h2 class="text-3xl font-bold text-green-900 mb-6">Invoice #{{ $invoice->id }}</h2>

    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600">
        <h3 class="text-xl font-semibold text-green-800 mb-4">Invoice Information</h3>
        <hr class="mb-4 border-gray-200">

        <p class="mb-2 text-lg"><strong class="text-gray-700">Invoice ID:</strong> <span class="text-gray-800">{{ $invoice->id }}</span></p>

        <p class="mb-2 text-lg">
            <strong class="text-gray-700">Campaign:</strong>
            @if($invoice->campaign)
                <span class="text-green-700 font-medium">{{ $invoice->campaign->name }}</span>
            @else
                <span class="text-gray-400">—</span>
            @endif
        </p>

        <p class="mb-2 text-lg"><strong class="text-gray-700">Amount:</strong> <span class="text-gray-800">${{ number_format($invoice->amount, 2) }}</span></p>

        <p class="mb-2 text-lg">
            <strong class="text-gray-700">Status:</strong>
            @if($invoice->status === 'paid')
                <span class="inline-block px-3 py-1 rounded-full text-white bg-green-600 text-sm font-semibold">Paid</span>
            @elseif($invoice->status === 'pending')
                <span class="inline-block px-3 py-1 rounded-full text-white bg-yellow-500 text-sm font-semibold">Pending</span>
            @else
                <span class="inline-block px-3 py-1 rounded-full text-white bg-red-600 text-sm font-semibold">Failed</span>
            @endif
        </p>

        <p class="mb-2 text-lg"><strong class="text-gray-700">Due Date:</strong> <span class="text-gray-800">{{ $invoice->due_date ?? '—' }}</span></p>

        <p class="mb-2 text-lg"><strong class="text-gray-700">Created At:</strong> <span class="text-gray-800">{{ $invoice->created_at }}</span></p>

    </div>

    <div class="mt-6 ">
        <a href="{{ route('advertiser.invoices.index') }}"
           class="inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition font-medium">
            Back to Invoices
        </a>
    </div>

</div>
@endsection
