@extends('layouts.app')

@section('title', '403 Forbidden')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Access Denied</h2>
        <p class="text-gray-500 mb-6">{{ $exception->getMessage() ?: 'You do not have permission to access this resource.' }}</p>
        <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Back to Dashboard
        </a>
    </div>
</div>
@endsection
