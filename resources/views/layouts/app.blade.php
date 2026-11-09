<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KDB Security Demo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                        🔒 KDB Security
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : '' }}">
                            Dashboard
                        </a>

                        {{-- Product Catalog: Admin, Data Analyst, Customer --}}
                        @if(auth()->user()->hasRole(['admin', 'data_analyst', 'customer']))
                            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                Products
                            </a>
                        @endif

                        {{-- Customer's own orders --}}
                        @if(auth()->user()->hasRole(['admin', 'customer']))
                            <a href="{{ route('orders.my') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('orders.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                My Orders
                            </a>
                        @endif

                        {{-- Customer Data Management: Admin, Data Analyst --}}
                        @if(auth()->user()->hasRole(['admin', 'data_analyst']))
                            <a href="{{ route('customers.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('customers.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                Customers
                            </a>
                            <a href="{{ route('transactions.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('transactions.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                Transactions
                            </a>
                        @endif

                        {{-- Audit Logs: Admin, Auditor --}}
                        @if(auth()->user()->hasRole(['admin', 'auditor']))
                            <a href="{{ route('audit.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('audit.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                Audit Logs
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        @php
                            $roleBadgeColors = [
                                'admin' => 'bg-red-100 text-red-800',
                                'data_analyst' => 'bg-blue-100 text-blue-800',
                                'auditor' => 'bg-green-100 text-green-800',
                                'customer' => 'bg-purple-100 text-purple-800',
                            ];
                            $roleLabels = [
                                'admin' => 'Admin',
                                'data_analyst' => 'Data Analyst',
                                'auditor' => 'Auditor',
                                'customer' => 'Customer',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeColors[auth()->user()->role] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $roleLabels[auth()->user()->role] ?? auth()->user()->role }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">✗</span>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-500">
            KDB Security Demo — Database Security Implementation with Laravel
        </div>
    </footer>
</body>
</html>
