@extends('admin.layouts.app')

@section('title','Invoices')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Invoices</h1>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Advertiser</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Campaign</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Amount</th>
                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($invoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $invoice->id }}</td>
                        <td class="px-4 py-2 text-sm">{{ $invoice->user->name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $invoice->campaign->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-right">${{ number_format($invoice->amount, 2) }}</td>
                        <td class="px-4 py-2 text-center text-sm">
                            <span class="px-2 py-1 rounded-full text-white
                                {{ $invoice->status === 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-sm flex flex-wrap justify-center gap-2">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-blue-600 hover:underline">View</a>

                            @if($invoice->status !== 'paid')
                                <form action="{{ route('admin.invoices.markPaid', $invoice) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Mark Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
