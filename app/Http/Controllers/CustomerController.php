<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Vendor;
use App\Services\CustomerService;
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
    public function create(CustomerService $customerService, CustomerStoreRequest $request)
    {
        $customerService->createCustomer($request);
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
    public function updateCustomer(CustomerService $customerService, $id)
    {
        $customer = $customerService->getCustomerById($id);
        return view('pages.Customer.updateCustomer', compact('customer'));
    }

    public function update(CustomerService $customerService, CustomerUpdateRequest $request, $id)
    {

        $customerService->updateCustomer($id, $request);
        return redirect(route('customer'));
    }

    public function searchCustomer(CustomerService $customerService, Request $request)
    {
        $customers = $customerService->searchContent($request);
        return view('pages.customer', compact('customers'));
    }

    public function delete(CustomerService $customerService, $id)
    {
        $customerService->deleteCustomer($id);
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
