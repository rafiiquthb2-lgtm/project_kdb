@extends('layouts.app')

@section('title', 'My Orders - KDB Security Demo')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">📦 My Orders</h1>
        <p class="text-gray-500 mt-1">Your transaction history. Customer ID: <span class="font-mono font-semibold">{{ auth()->user()->customer_id }}</span></p>
    </div>
    <a href="{{ route('orders.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
        + New Order
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tax</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Discount</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Paid</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-mono text-indigo-600 font-medium">{{ $trx->transaction_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trx->transaction_date instanceof \Carbon\Carbon ? $trx->transaction_date->format('d M Y') : $trx->transaction_date }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @php
                            $paymentIcons = ['Credit Card' => '💳', 'Bank Transfer' => '🏦', 'E-Wallet' => '📱', 'COD' => '📦', 'QRIS' => '📷'];
                        @endphp
                        {{ $paymentIcons[$trx->payment_method] ?? '💰' }} {{ $trx->payment_method }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-900 text-right">Rp {{ number_format($trx->before_tax, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-right">Rp {{ number_format($trx->tax, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-right">
                        @if($trx->transaction_discount > 0)
                            <span class="text-green-600">-Rp {{ number_format($trx->transaction_discount, 0, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Rp {{ number_format($trx->total_paid, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center">
                        <div class="text-gray-400">
                            <span class="text-4xl block mb-2">🛒</span>
                            <p class="text-lg font-medium text-gray-500">No orders yet</p>
                            <p class="text-sm">Start shopping from the <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Product Catalog</a>!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
