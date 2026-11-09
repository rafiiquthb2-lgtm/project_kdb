@extends('layouts.app')

@section('title', 'Customer Detail - KDB Security Demo')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Customer Detail</h1>
            <p class="text-gray-500 mt-1">ID: {{ $customer->customer_id }}</p>
        </div>
        <a href="{{ route('customers.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Customer ID</p>
                <p class="text-gray-900 font-mono">{{ $customer->customer_id }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Registration Date</p>
                <p class="text-gray-900">{{ $customer->registration_date?->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Encrypted Fields -->
        <div class="border-t pt-6">
            <h3 class="text-sm font-semibold text-orange-600 mb-4">🔐 PII Fields (AES-256 Encrypted)</h3>
            
            <div class="space-y-4">
                <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Customer Name</p>
                    @if($canDecrypt)
                        <p class="text-gray-900 font-medium text-lg">{{ $customer->customer_name }}</p>
                        <details class="mt-2">
                            <summary class="text-xs text-orange-600 cursor-pointer">View encrypted value in DB</summary>
                            <p class="mt-1 text-xs font-mono text-gray-400 break-all bg-white p-2 rounded border">{{ $customer->getRawCustomerName() }}</p>
                        </details>
                    @else
                        <p class="text-red-500 font-mono text-sm">[ENCRYPTED — Admin access required]</p>
                    @endif
                </div>

                <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Date of Birth</p>
                    @if($canDecrypt)
                        <p class="text-gray-900 font-medium text-lg">{{ $customer->dob }}</p>
                        <details class="mt-2">
                            <summary class="text-xs text-orange-600 cursor-pointer">View encrypted value in DB</summary>
                            <p class="mt-1 text-xs font-mono text-gray-400 break-all bg-white p-2 rounded border">{{ $customer->getRawDob() }}</p>
                        </details>
                    @else
                        <p class="text-red-500 font-mono text-sm">[ENCRYPTED — Admin access required]</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Non-encrypted Fields -->
        <div class="border-t pt-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-4">Other Fields (Not Encrypted)</h3>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Customer Type</p>
                    <p class="text-gray-900">{{ $customer->customer_type }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Province</p>
                    <p class="text-gray-900">{{ $customer->province }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Registration Channel</p>
                    <p class="text-gray-900">{{ $customer->registration_channel }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
