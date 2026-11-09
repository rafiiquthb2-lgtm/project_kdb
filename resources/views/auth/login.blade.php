@extends('layouts.app')

@section('title', 'Login - KDB Security Demo')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🔒 KDB Security</h1>
            <p class="text-gray-500 mt-2">Database Security Demo — Sign In</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium transition">
                Sign In
            </button>
        </form>

        <div class="mt-8 border-t pt-6">
            <p class="text-sm text-gray-500 text-center mb-3">Demo Accounts:</p>
            <div class="space-y-2 text-xs text-gray-600">
                <div class="flex justify-between bg-red-50 p-2 rounded"><span><strong>Admin:</strong> admin@kdb.test</span><span>password</span></div>
                <div class="flex justify-between bg-blue-50 p-2 rounded"><span><strong>Analyst:</strong> analyst@kdb.test</span><span>password</span></div>
                <div class="flex justify-between bg-green-50 p-2 rounded"><span><strong>Auditor:</strong> auditor@kdb.test</span><span>password</span></div>
                <div class="flex justify-between bg-purple-50 p-2 rounded"><span><strong>Customer:</strong> customer@kdb.test</span><span>password</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
