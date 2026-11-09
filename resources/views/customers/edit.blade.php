@extends('layouts.app')

@section('title', 'Edit Customer - KDB Security Demo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Customer: {{ $customer->customer_id }}</h1>
        <p class="text-gray-500 mt-1">Updated PII fields will be re-encrypted. Changes will be logged in Audit Log.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('customers.update', $customer->customer_id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer ID</label>
                    <input type="text" value="{{ $customer->customer_id }}" disabled
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-500">
                </div>
                <div>
                    <label for="registration_date" class="block text-sm font-medium text-gray-700 mb-1">Registration Date</label>
                    <input type="date" name="registration_date" id="registration_date" 
                        value="{{ old('registration_date', $customer->registration_date?->format('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Customer Name <span class="text-xs text-orange-500 font-normal">🔐 Will be re-encrypted</span>
                </label>
                <input type="text" name="customer_name" id="customer_name" 
                    value="{{ old('customer_name', $customer->customer_name) }}" required
                    class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-orange-50">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>
                    <select name="customer_type" id="customer_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Regular" {{ old('customer_type', $customer->customer_type) === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Premium" {{ old('customer_type', $customer->customer_type) === 'Premium' ? 'selected' : '' }}>Premium</option>
                        <option value="VIP" {{ old('customer_type', $customer->customer_type) === 'VIP' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">
                        Date of Birth <span class="text-xs text-orange-500 font-normal">🔐 Will be re-encrypted</span>
                    </label>
                    <input type="date" name="dob" id="dob" 
                        value="{{ old('dob', $customer->dob) }}" required
                        class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-orange-50">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                    <input type="text" name="province" id="province" 
                        value="{{ old('province', $customer->province) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="registration_channel" class="block text-sm font-medium text-gray-700 mb-1">Registration Channel</label>
                    <select name="registration_channel" id="registration_channel" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Website" {{ old('registration_channel', $customer->registration_channel) === 'Website' ? 'selected' : '' }}>Website</option>
                        <option value="Mobile App" {{ old('registration_channel', $customer->registration_channel) === 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                        <option value="Store" {{ old('registration_channel', $customer->registration_channel) === 'Store' ? 'selected' : '' }}>Store</option>
                        <option value="Social Media" {{ old('registration_channel', $customer->registration_channel) === 'Social Media' ? 'selected' : '' }}>Social Media</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('customers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    Update Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
