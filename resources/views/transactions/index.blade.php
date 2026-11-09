@extends('layouts.app')

@section('title', 'Transactions - KDB Security Demo')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Transaction Data</h1>
    <p class="text-gray-500 mt-1">Read-only view of transaction records.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Before Tax</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tax</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Paid</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $trx->transaction_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trx->transaction_date }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trx->customer_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trx->payment_method }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-right">Rp {{ number_format($trx->before_tax, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-right">Rp {{ number_format($trx->tax, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">Rp {{ number_format($trx->total_paid, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No transaction data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
