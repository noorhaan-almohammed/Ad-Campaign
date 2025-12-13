@extends('advertiser.layout')

@section('title', 'Invoices')

@section('content')
<div class="p-6">

    <h2 class="text-3xl font-bold text-green-900 mb-6">Invoices</h2>

    @if($invoices->count() == 0)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-4">
            No invoices found.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Invoice ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Campaign</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Due Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $invoice->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            @if($invoice->campaign)
                                <span class="text-green-700 font-medium">{{ $invoice->campaign->name }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($invoice->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($invoice->status === 'paid')
                                <span class="inline-block px-3 py-1 rounded-full text-white bg-green-600 text-sm font-semibold">Paid</span>
                            @elseif($invoice->status === 'pending')
                                <span class="inline-block px-3 py-1 rounded-full text-white bg-yellow-500 text-sm font-semibold">Pending</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full text-white bg-red-600 text-sm font-semibold">Failed</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $invoice->due_date ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('advertiser.invoices.show', $invoice->id) }}"
                               class="inline-block px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm font-medium">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection
