<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;

class ProductCatalogController extends Controller
{
    /**
     * Display product catalog (available to Admin, Data Analyst, and Customer).
     */
    public function index()
    {
        $products = ProductDetail::paginate(12);
        return view('products.catalog', compact('products'));
    }

    /**
     * Show single product detail.
     */
    public function show(string $skuId)
    {
        $product = ProductDetail::findOrFail($skuId);
        return view('products.show', compact('product'));
    }
}
