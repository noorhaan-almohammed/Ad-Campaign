@extends('advertiser.layout')

@section('content')

<h2 class="text-3xl font-bold mb-8 text-green-900">Dashboard Overview</h2>
<div class="flex gap-4 my-8">
    <a href="{{ route('advertiser.campaigns.create') }}" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        + New Campaign
    </a>
    <a href="{{ route('advertiser.invoices.index') }}" class="px-5 py-2 bg-gray-300 text-gray-900 rounded hover:bg-gray-400">
        View Invoices
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-900">Total Campaigns</h3>
        <p class="text-4xl font-bold mt-3 text-gray-800">{{ $campaigns_count }} Campaigns</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-900">Active Campaigns</h3>
        <p class="text-4xl font-bold mt-3 text-gray-800">{{ $active_campaigns }} Campaigns</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-900">Invoices</h3>
        <p class="text-4xl font-bold mt-3 text-gray-800">{{ $invoices_count }} Invoices</p>
    </div>

</div>


    {{-- Transactions Table --}}
    <div class="bg-white p-6 rounded-xl shadow mt-8">
        <h3 class="text-2xl font-semibold mb-4">Transaction History</h3>

        <table class="w-full border">
            <thead>
                <tr class="bg-green-100 text-left">
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Amount</th>
                    <th class="p-2 border">Reference</th>
                    <th class="p-2 border">Notes</th>
                    <th class="p-2 border">Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($transactions as $t)
                    <tr class="hover:bg-green-50">
                        <td class="p-2 border">{{ ucfirst($t->type) }}</td>
                        <td class="p-2 border">
                            @if ($t->amount >0 )
                                <span class="text-green-900"> {{ $t->amount }} $</span>
                            @else
                                <span class="text-red-600"> {{ $t->amount }} $</span>
                            @endif
                        </td>
                        <td class="p-2 border">{{ $t->reference ?? '-' }}</td>
                        <td class="p-2 border">{{ $t->notes ?? '-' }}</td>
                        <td class="p-2 border">{{ $t->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
