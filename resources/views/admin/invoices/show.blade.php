@extends('admin.layouts.app')

@section('title','Invoice Details')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Invoice #{{ $invoice->id }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><span class="font-semibold">Advertiser:</span> {{ $invoice->user->name }}</p>
            <p><span class="font-semibold">Campaign:</span> {{ $invoice->campaign->name ?? '-' }}</p>
            <p><span class="font-semibold">Amount:</span> ${{ number_format($invoice->amount, 2) }}</p>
            <p>
                <span class="font-semibold">Status:</span>
                <span class="px-2 py-1 rounded-full text-white
                    {{ $invoice->status === 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
            <p><span class="font-semibold">Due Date:</span> {{ $invoice->due_date }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.invoices.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Back to Invoices
        </a>
    </div>
</div>
@endsection
