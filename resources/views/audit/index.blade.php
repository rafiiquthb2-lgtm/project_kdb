@extends('layouts.app')

@section('title', 'Audit Logs - KDB Security Demo')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">📋 Audit Logs</h1>
    <p class="text-gray-500 mt-1">Complete history of data changes on monitored tables (customer_detail, transaction_detail).</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('audit.index') }}" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Table</label>
            <select name="table_name" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Tables</option>
                <option value="customer_detail" {{ request('table_name') === 'customer_detail' ? 'selected' : '' }}>customer_detail</option>
                <option value="transaction_detail" {{ request('table_name') === 'transaction_detail' ? 'selected' : '' }}>transaction_detail</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Event Type</label>
            <select name="event_type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Events</option>
                <option value="INSERT" {{ request('event_type') === 'INSERT' ? 'selected' : '' }}>INSERT</option>
                <option value="UPDATE" {{ request('event_type') === 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                <option value="DELETE" {{ request('event_type') === 'DELETE' ? 'selected' : '' }}>DELETE</option>
            </select>
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                Filter
            </button>
            <a href="{{ route('audit.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition ml-1">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Audit Log Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Table</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Record ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $log->id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600" title="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-4 py-3 text-sm">
                        @php
                            $eventColors = ['INSERT' => 'bg-green-100 text-green-800', 'UPDATE' => 'bg-yellow-100 text-yellow-800', 'DELETE' => 'bg-red-100 text-red-800', 'READ' => 'bg-blue-100 text-blue-800'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $eventColors[$log->event_type] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $log->event_type }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $log->table_name }}</td>
                    <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $log->record_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 text-sm">
                        <a href="{{ route('audit.show', $log->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">No audit logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $logs->links() }}
    </div>
</div>
@endsection
