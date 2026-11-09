@extends('layouts.app')

@section('title', 'Product Detail - KDB Security Demo')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">← Back to catalog</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-4 overflow-hidden">
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-12 text-center">
            <span class="text-6xl">
                @switch($product->category)
                    @case('Electronics') 📱 @break
                    @case('Fashion') 👟 @break
                    @case('Home') 🏠 @break
                    @case('Beauty') ✨ @break
                    @default 📦
                @endswitch
            </span>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $product->category }}</span>
                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-xs rounded-full">{{ $product->brand }}</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-900">{{ $product->sku_name }}</h1>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">SKU ID</p>
                    <p class="font-mono text-gray-900">{{ $product->sku_id }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Product</p>
                    <p class="text-gray-900">{{ $product->product }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Variant</p>
                    <p class="text-gray-900">{{ $product->variant ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Brand</p>
                    <p class="text-gray-900">{{ $product->brand }}</p>
                </div>
            </div>

            <div class="border-t pt-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Price</p>
                    <p class="text-3xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                @if(auth()->user()->hasRole(['admin', 'customer']))
                    <a href="{{ route('orders.create', ['sku' => $product->sku_id]) }}"
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-medium">
                        🛒 Buy Now
                    </a>
                @endif
            </div>

            @if(auth()->user()->isAdmin())
            <div class="border-t pt-4">
                <p class="text-xs text-gray-400 uppercase font-medium mb-2">Admin Only — Cost Info</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500">COGS (Harga Pokok)</p>
                        <p class="font-semibold text-gray-900">Rp {{ number_format($product->cogs, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500">Margin</p>
                        <p class="font-semibold text-green-700">Rp {{ number_format($product->price - $product->cogs, 0, ',', '.') }}
                            ({{ round(($product->price - $product->cogs) / $product->price * 100, 1) }}%)
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
