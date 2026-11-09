<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use App\Models\TransactionDetail;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerOrderController extends Controller
{
    /**
     * Show customer's own transactions/orders.
     */
    public function myOrders()
    {
        $user = auth()->user();
        $customerId = $user->customer_id;

        if (!$customerId) {
            return redirect()->route('dashboard')
                ->with('error', 'Your account is not linked to a customer profile.');
        }

        $transactions = TransactionDetail::where('customer_id', $customerId)
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        return view('orders.index', compact('transactions'));
    }

    /**
     * Show order creation form (select product, qty).
     */
    public function create()
    {
        $products = ProductDetail::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Process a new order/transaction.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $customerId = $user->customer_id;

        if (!$customerId) {
            return redirect()->route('dashboard')
                ->with('error', 'Your account is not linked to a customer profile.');
        }

        $validated = $request->validate([
            'sku_id'         => 'required|exists:product_detail,sku_id',
            'quantity'        => 'required|integer|min:1|max:100',
            'payment_method'  => 'required|string|in:Credit Card,Bank Transfer,E-Wallet,COD,QRIS',
        ]);

        $product = ProductDetail::findOrFail($validated['sku_id']);
        $qty = $validated['quantity'];

        // Calculate pricing
        $itemTotal = $product->price * $qty;
        $discount = ($qty >= 3) ? $itemTotal * 0.05 : 0; // 5% discount for 3+ items
        $beforeDiscount = $itemTotal;
        $afterDiscount = $itemTotal - $discount;
        $tax = $afterDiscount * 0.11; // PPN 11%
        $shipping = 15000;
        $totalPaid = $afterDiscount + $tax + $shipping;

        // Generate IDs
        $trxId = 'TRX-' . strtoupper(Str::random(8));
        $orderId = 'ORD-' . strtoupper(Str::random(8));

        // Create transaction (will be audit-logged by Observer)
        $transaction = TransactionDetail::create([
            'transaction_id'       => $trxId,
            'transaction_date'     => now()->toDateString(),
            'customer_id'          => $customerId,
            'payment_method'       => $validated['payment_method'],
            'before_tax'           => $afterDiscount,
            'tax'                  => $tax,
            'after_tax'            => $afterDiscount + $tax,
            'shipping_cost'        => $shipping,
            'transaction_discount' => $discount,
            'total_paid'           => $totalPaid,
        ]);

        // Create order detail
        OrderDetail::create([
            'order_id'        => $orderId,
            'transaction_id'  => $trxId,
            'customer_id'     => $customerId,
            'order_date'      => now()->toDateString(),
            'channel_type'    => 'Website',
            'sku_id'          => $product->sku_id,
            'quantity'        => $qty,
            'price'           => $product->price,
            'before_discount' => $beforeDiscount,
            'discount_item'   => $discount,
            'after_discount'  => $afterDiscount,
            'is_gross'        => true,
            'is_valid'        => true,
            'is_net'          => true,
        ]);

        return redirect()->route('orders.my')
            ->with('success', "Order berhasil! Transaction ID: {$trxId}, Total: Rp " . number_format($totalPaid, 0, ',', '.'));
    }
}
