@extends('layouts.app')

@section('title', 'Add Customer - KDB Security Demo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add New Customer</h1>
        <p class="text-gray-500 mt-1">PII fields (Name, DOB) will be automatically encrypted with AES-256 before storage.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('customers.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer ID</label>
                    <input type="text" name="customer_id" id="customer_id" value="{{ old('customer_id') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="e.g., CUST-001">
                </div>
                <div>
                    <label for="registration_date" class="block text-sm font-medium text-gray-700 mb-1">Registration Date</label>
                    <input type="date" name="registration_date" id="registration_date" value="{{ old('registration_date', date('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Customer Name <span class="text-xs text-orange-500 font-normal">🔐 Will be encrypted</span>
                </label>
                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                    class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-orange-50"
                    placeholder="Full name (PII - will be encrypted)">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>
                    <select name="customer_type" id="customer_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select type</option>
                        <option value="Regular" {{ old('customer_type') === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Premium" {{ old('customer_type') === 'Premium' ? 'selected' : '' }}>Premium</option>
                        <option value="VIP" {{ old('customer_type') === 'VIP' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">
                        Date of Birth <span class="text-xs text-orange-500 font-normal">🔐 Will be encrypted</span>
                    </label>
                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required
                        class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-orange-50">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                    <input type="text" name="province" id="province" value="{{ old('province') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="e.g., DKI Jakarta">
                </div>
                <div>
                    <label for="registration_channel" class="block text-sm font-medium text-gray-700 mb-1">Registration Channel</label>
                    <select name="registration_channel" id="registration_channel" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select channel</option>
                        <option value="Website" {{ old('registration_channel') === 'Website' ? 'selected' : '' }}>Website</option>
                        <option value="Mobile App" {{ old('registration_channel') === 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                        <option value="Store" {{ old('registration_channel') === 'Store' ? 'selected' : '' }}>Store</option>
                        <option value="Social Media" {{ old('registration_channel') === 'Social Media' ? 'selected' : '' }}>Social Media</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('customers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    Save Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
