@extends('layouts.app')

@section('title', 'Place Order - KDB Security Demo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">🛒 Place Order</h1>
        <p class="text-gray-500 mt-1">Select a product and complete your order. Transaction will be automatically logged in the Audit system.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('orders.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="sku_id" class="block text-sm font-medium text-gray-700 mb-1">Select Product</label>
                <select name="sku_id" id="sku_id" required onchange="updatePrice()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">— Choose a product —</option>
                    @foreach($products as $p)
                        <option value="{{ $p->sku_id }}"
                                data-price="{{ $p->price }}"
                                {{ (old('sku_id', request('sku')) == $p->sku_id) ? 'selected' : '' }}>
                            {{ $p->sku_name }} — Rp {{ number_format($p->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="100" required
                    onchange="updatePrice()" oninput="updatePrice()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-400 mt-1">💡 Order 3+ items to get 5% discount!</p>
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select name="payment_method" id="payment_method" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">— Select payment —</option>
                    <option value="Credit Card" {{ old('payment_method') === 'Credit Card' ? 'selected' : '' }}>💳 Credit Card</option>
                    <option value="Bank Transfer" {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                    <option value="E-Wallet" {{ old('payment_method') === 'E-Wallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                    <option value="COD" {{ old('payment_method') === 'COD' ? 'selected' : '' }}>📦 Cash on Delivery</option>
                    <option value="QRIS" {{ old('payment_method') === 'QRIS' ? 'selected' : '' }}>📷 QRIS</option>
                </select>
            </div>

            <!-- Price Summary -->
            <div id="priceSummary" class="border-t pt-4 space-y-2 text-sm" style="display:none;">
                <h3 class="font-semibold text-gray-700 mb-2">Order Summary</h3>
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span id="subtotal" class="font-medium">-</span></div>
                <div class="flex justify-between text-green-600"><span>Discount</span><span id="discount">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tax (PPN 11%)</span><span id="tax">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Shipping</span><span>Rp 15.000</span></div>
                <div class="flex justify-between border-t pt-2 text-lg font-bold text-indigo-600">
                    <span>Total</span><span id="total">-</span>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    ✓ Place Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function formatRupiah(n) {
    return 'Rp ' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function updatePrice() {
    const select = document.getElementById('sku_id');
    const qty = parseInt(document.getElementById('quantity').value) || 0;
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option?.dataset?.price) || 0;
    const summary = document.getElementById('priceSummary');

    if (price > 0 && qty > 0) {
        summary.style.display = 'block';
        const sub = price * qty;
        const disc = qty >= 3 ? sub * 0.05 : 0;
        const afterDisc = sub - disc;
        const tax = afterDisc * 0.11;
        const shipping = 15000;
        const total = afterDisc + tax + shipping;

        document.getElementById('subtotal').textContent = formatRupiah(sub);
        document.getElementById('discount').textContent = disc > 0 ? '-' + formatRupiah(disc) : '-';
        document.getElementById('tax').textContent = formatRupiah(tax);
        document.getElementById('total').textContent = formatRupiah(total);
    } else {
        summary.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updatePrice);
</script>
@endsection
