<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = TransactionDetail::with('customer')->paginate(15);
        return view('transactions.index', compact('transactions'));
    }

    public function show(string $id)
    {
        $transaction = TransactionDetail::with(['customer', 'orders'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }
}
