<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'color_code' => 'required|string',
    ]);

    Customer::create(
        $request->only('name', 'color_code')
    );

    return redirect()->route('customers.index')
        ->with('success', 'Customer created successfully.');
}

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

public function update(Request $request, Customer $customer)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'color_code' => 'required|string',
    ]);

    $customer->update(
        $request->only('name', 'color_code')
    );

    return redirect()->route('customers.index')
        ->with('success', 'Customer updated successfully.');
}
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}