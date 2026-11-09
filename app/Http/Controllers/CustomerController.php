<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetail;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display listing of customers.
     * Admin sees decrypted data, others see encrypted placeholders.
     */
    public function index()
    {
        $customers = CustomerDetail::paginate(15);
        $user = auth()->user();
        $canDecrypt = $user->isAdmin();

        return view('customers.index', compact('customers', 'canDecrypt'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'          => 'required|string|unique:customer_detail,customer_id',
            'registration_date'    => 'required|date',
            'customer_name'        => 'required|string|max:255',
            'customer_type'        => 'required|string|max:100',
            'dob'                  => 'required|date',
            'province'             => 'required|string|max:100',
            'registration_channel' => 'required|string|max:100',
        ]);

        CustomerDetail::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully. PII data has been encrypted.');
    }

    /**
     * Show a single customer.
     */
    public function show(string $id)
    {
        $customer = CustomerDetail::findOrFail($id);
        $user = auth()->user();
        $canDecrypt = $user->isAdmin();

        return view('customers.show', compact('customer', 'canDecrypt'));
    }

    /**
     * Show the form for editing a customer.
     */
    public function edit(string $id)
    {
        $customer = CustomerDetail::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update a customer.
     */
    public function update(Request $request, string $id)
    {
        $customer = CustomerDetail::findOrFail($id);

        $validated = $request->validate([
            'registration_date'    => 'required|date',
            'customer_name'        => 'required|string|max:255',
            'customer_type'        => 'required|string|max:100',
            'dob'                  => 'required|date',
            'province'             => 'required|string|max:100',
            'registration_channel' => 'required|string|max:100',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully. Changes have been logged.');
    }

    /**
     * Remove a customer.
     */
    public function destroy(string $id)
    {
        $customer = CustomerDetail::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully. Deletion has been logged.');
    }
}
