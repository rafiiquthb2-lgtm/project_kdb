@extends('layouts.app')

@section('title', 'Dashboard - KDB Security Demo')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 mt-1">Welcome back, {{ $user->name }}. You are logged in as <strong>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</strong>.</p>
</div>

{{-- ============================================= --}}
{{-- ADMIN / DATA ANALYST — Global Stats           --}}
{{-- ============================================= --}}
@if($user->hasRole(['admin', 'data_analyst']))
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Customers</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_customers'] ?? 0) }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-3"><span class="text-2xl">👥</span></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_transactions'] ?? 0) }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3"><span class="text-2xl">💳</span></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders'] ?? 0) }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3"><span class="text-2xl">📦</span></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3"><span class="text-2xl">💰</span></div>
        </div>
    </div>
</div>
@endif

{{-- ============================================= --}}
{{-- CUSTOMER — Personal Stats                     --}}
{{-- ============================================= --}}
@if($user->isCustomer())
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">My Transactions</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['my_transactions'] ?? 0) }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3"><span class="text-2xl">🧾</span></div>
        </div>
        <a href="{{ route('orders.my') }}" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">View my orders →</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Spent</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['my_total_spent'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3"><span class="text-2xl">💰</span></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Products Available</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_products'] ?? 0) }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-3"><span class="text-2xl">🛍️</span></div>
        </div>
        <a href="{{ route('products.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Browse catalog →</a>
    </div>
</div>
@endif

{{-- ============================================= --}}
{{-- Security Features Info                        --}}
{{-- ============================================= --}}
<div class="grid grid-cols-1 md:grid-cols-{{ $user->isCustomer() ? '2' : '3' }} gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">🛡️ RBAC</h3>
        <p class="text-sm text-gray-600">Role-Based Access Control with 4 roles: Admin, Data Analyst, Auditor, and Customer.</p>
        <div class="mt-3">
            @php
                $roleColor = match($user->role) {
                    'admin' => 'bg-red-100 text-red-800',
                    'data_analyst' => 'bg-blue-100 text-blue-800',
                    'auditor' => 'bg-green-100 text-green-800',
                    'customer' => 'bg-purple-100 text-purple-800',
                    default => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                Your role: {{ ucfirst(str_replace('_', ' ', $user->role)) }}
            </span>
        </div>
    </div>
    @if(!$user->isCustomer())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">🔐 Encryption</h3>
        <p class="text-sm text-gray-600">AES-256 encryption for PII data (customer_name, dob). Only Admin can view decrypted data.</p>
        <div class="mt-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $user->isAdmin() ? '✓ Can decrypt' : '✗ Cannot decrypt' }}
            </span>
        </div>
    </div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">📋 Audit Log</h3>
        <p class="text-sm text-gray-600">Automatic logging of all CRUD operations on customer and transaction tables.</p>
        <div class="mt-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->hasRole(['admin', 'auditor']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $user->hasRole(['admin', 'auditor']) ? '✓ Can view logs' : '✗ Cannot view logs' }}
            </span>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- AUDIT ACTIVITY (Admin / Auditor)              --}}
{{-- ============================================= --}}
@if($user->hasRole(['admin', 'auditor']) && !empty($stats['recent_activities']) && $stats['recent_activities']->count())
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Audit Activity</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Table</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Record ID</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($stats['recent_activities'] as $activity)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $activity->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $activity->user->name ?? 'System' }}</td>
                    <td class="px-4 py-3 text-sm">
                        @php
                            $eventColors = ['INSERT' => 'bg-green-100 text-green-800', 'UPDATE' => 'bg-yellow-100 text-yellow-800', 'DELETE' => 'bg-red-100 text-red-800', 'READ' => 'bg-blue-100 text-blue-800'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $eventColors[$activity->event_type] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $activity->event_type }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $activity->table_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 font-mono">{{ $activity->record_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
