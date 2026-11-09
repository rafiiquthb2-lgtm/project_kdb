@extends('layouts.app')

@section('title', 'Transaction Detail - KDB Security Demo')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Transaction Detail</h1>
            <p class="text-gray-500 mt-1">ID: {{ $transaction->transaction_id }}</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">← Back to transactions</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Transaction ID</p>
                <p class="text-gray-900 font-mono font-medium">{{ $transaction->transaction_id }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Date</p>
                <p class="text-gray-900">{{ $transaction->transaction_date }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Customer ID</p>
                <p class="text-gray-900 font-mono">{{ $transaction->customer_id }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Payment Method</p>
                <p class="text-gray-900">{{ $transaction->payment_method }}</p>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Financial Details</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Before Tax</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($transaction->before_tax, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Tax</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">After Tax</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($transaction->after_tax, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Shipping Cost</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Discount</p>
                    <p class="text-lg font-semibold text-red-600">-Rp {{ number_format($transaction->transaction_discount, 0, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4 border-2 border-indigo-200">
                    <p class="text-xs text-indigo-600 uppercase font-semibold">Total Paid</p>
                    <p class="text-xl font-bold text-indigo-700">Rp {{ number_format($transaction->total_paid, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        @if($transaction->orders && $transaction->orders->count() > 0)
        <div class="border-t pt-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Order Items</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">After Discount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transaction->orders as $order)
                    <tr>
                        <td class="px-4 py-2 text-sm font-mono">{{ $order->order_id }}</td>
                        <td class="px-4 py-2 text-sm">{{ $order->sku_id }}</td>
                        <td class="px-4 py-2 text-sm text-right">{{ $order->quantity }}</td>
                        <td class="px-4 py-2 text-sm text-right">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm text-right font-medium">Rp {{ number_format($order->after_discount, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
