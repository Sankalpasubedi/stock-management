<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Brand;
use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addVendor()
    {
        return view('pages.Vendor.addVendor');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(VendorService $vendorService, VendorStoreRequest $request)
    {
        $vendorService->createVendor($request);
        return redirect(route('vendor'));
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
    public function updateVendor(VendorService $vendorService, $id)
    {
        $vendor = $vendorService->getVendorById($id);
        return view('pages.Vendor.updateVendor', compact('vendor'));
    }

    public function update(VendorService $vendorService, VendorUpdateRequest $request, $id)
    {
        $vendorService->updateVendor($request, $id);
        return redirect(route('vendor'));
    }

    public function searchVendor(VendorService $vendorService, Request $request)
    {
        $vendors = $vendorService->searchContent($request);

        return view('pages.vendors', compact('vendors'));
    }

    public function delete(VendorService $vendorService, $id)
    {
        $vendorService->delete($id);
        return redirect(route('vendor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brands)
    {
        //
    }
}
