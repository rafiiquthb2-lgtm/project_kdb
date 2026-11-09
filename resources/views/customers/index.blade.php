@extends('layouts.app')

@section('title', 'Customer Data - KDB Security Demo')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Customer Data</h1>
        <p class="text-gray-500 mt-1">
            @if($canDecrypt)
                <span class="text-green-600">🔓 PII data is decrypted (Admin access)</span>
            @else
                <span class="text-red-600">🔒 PII data is encrypted (insufficient permissions)</span>
            @endif
        </p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('customers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
            + Add Customer
        </a>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date of Birth</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Province</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Channel</th>
                    @if($canDecrypt)
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Encrypted Value (DB)</th>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $customer->customer_id }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($canDecrypt)
                            <span class="text-gray-900 font-medium">{{ $customer->customer_name }}</span>
                        @else
                            <span class="text-red-500 font-mono text-xs bg-red-50 px-2 py-1 rounded">[ENCRYPTED]</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $customer->customer_type }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($canDecrypt)
                            <span class="text-gray-900">{{ $customer->dob }}</span>
                        @else
                            <span class="text-red-500 font-mono text-xs bg-red-50 px-2 py-1 rounded">[ENCRYPTED]</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $customer->province }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $customer->registration_channel }}</td>
                    @if($canDecrypt)
                        <td class="px-4 py-3 text-xs font-mono text-gray-400 max-w-xs truncate" title="{{ $customer->getRawCustomerName() }}">
                            {{ Str::limit($customer->getRawCustomerName(), 40) }}
                        </td>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <td class="px-4 py-3 text-sm space-x-2">
                            <a href="{{ route('customers.edit', $customer->customer_id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <form method="POST" action="{{ route('customers.destroy', $customer->customer_id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">No customer data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $customers->links() }}
    </div>
</div>
@endsection
