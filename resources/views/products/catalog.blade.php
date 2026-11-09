@extends('layouts.app')

@section('title', 'Product Catalog - KDB Security Demo')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">🛍️ Product Catalog</h1>
    <p class="text-gray-500 mt-1">Browse available products.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($products as $product)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 text-center">
            <span class="text-4xl">
                @switch($product->category)
                    @case('Electronics') 📱 @break
                    @case('Fashion') 👟 @break
                    @case('Home') 🏠 @break
                    @case('Beauty') ✨ @break
                    @default 📦
                @endswitch
            </span>
        </div>
        <div class="p-5">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $product->category }}</span>
                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-xs rounded-full">{{ $product->brand }}</span>
            </div>
            <h3 class="font-semibold text-gray-900 text-lg mb-1">{{ $product->sku_name }}</h3>
            <p class="text-sm text-gray-500 mb-3">SKU: {{ $product->sku_id }}</p>

            <div class="flex items-center justify-between">
                <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @if(auth()->user()->hasRole(['admin', 'customer']))
                    <a href="{{ route('orders.create', ['sku' => $product->sku_id]) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                        Buy Now
                    </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-gray-500">
        No products available.
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
