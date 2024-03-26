<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Vendor;
use Cassandra\Custom;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addCustomer()
    {
        return view('pages.Customer.addCustomer');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CustomerStoreRequest $request)
    {
        Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ]);
        return redirect(route('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brands)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCustomer($id)
    {
        $customer = Customer::where('id', $id)->first();
        return view('pages.Customer.updateCustomer', compact('customer'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {

        Customer::where('id', $id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ]);
        return redirect(route('customer'));
    }

    public function delete($id)
    {
        Customer::where('id', $id)->delete();
        return redirect(route('customer'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brands)
    {
        //
    }
}
