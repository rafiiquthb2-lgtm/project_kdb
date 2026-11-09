@extends('layouts.app')

@section('title', 'Audit Detail - KDB Security Demo')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Log #{{ $auditLog->id }}</h1>
            <p class="text-gray-500 mt-1">{{ $auditLog->created_at->format('d M Y H:i:s') }}</p>
        </div>
        <a href="{{ route('audit.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">← Back to logs</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">User</p>
                <p class="text-gray-900 font-medium">{{ $auditLog->user->name ?? 'System' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Event Type</p>
                @php
                    $eventColors = ['INSERT' => 'bg-green-100 text-green-800', 'UPDATE' => 'bg-yellow-100 text-yellow-800', 'DELETE' => 'bg-red-100 text-red-800', 'READ' => 'bg-blue-100 text-blue-800'];
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $eventColors[$auditLog->event_type] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $auditLog->event_type }}
                </span>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Table</p>
                <p class="text-gray-900 font-mono">{{ $auditLog->table_name }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Record ID</p>
                <p class="text-gray-900 font-mono">{{ $auditLog->record_id }}</p>
            </div>
        </div>

        <div>
            <p class="text-xs font-medium text-gray-500 uppercase mb-1">IP Address</p>
            <p class="text-gray-900 font-mono">{{ $auditLog->ip_address ?? 'N/A' }}</p>
        </div>

        @if($auditLog->old_values)
        <div class="border-t pt-4">
            <h3 class="text-sm font-semibold text-red-600 mb-2">Old Values</h3>
            <pre class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-gray-800 overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        @if($auditLog->new_values)
        <div class="border-t pt-4">
            <h3 class="text-sm font-semibold text-green-600 mb-2">New Values</h3>
            <pre class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm text-gray-800 overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        @if($auditLog->old_values && $auditLog->new_values)
        <div class="border-t pt-4">
            <h3 class="text-sm font-semibold text-indigo-600 mb-2">Changes Summary</h3>
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                <div class="space-y-2">
                    @php
                        $oldValues = is_array($auditLog->old_values) ? $auditLog->old_values : (array) $auditLog->old_values;
                        $newValues = is_array($auditLog->new_values) ? $auditLog->new_values : (array) $auditLog->new_values;
                    @endphp
                    @foreach($newValues as $key => $newVal)
                        @if(isset($oldValues[$key]) && $oldValues[$key] !== $newVal)
                        <div class="flex items-start text-sm">
                            <span class="font-mono font-medium text-gray-700 w-40 shrink-0">{{ $key }}:</span>
                            <div>
                                <span class="text-red-600 line-through">{{ is_array($oldValues[$key]) ? json_encode($oldValues[$key]) : $oldValues[$key] }}</span>
                                <span class="text-gray-400 mx-2">→</span>
                                <span class="text-green-600 font-medium">{{ is_array($newVal) ? json_encode($newVal) : $newVal }}</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
