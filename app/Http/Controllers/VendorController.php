<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Brand;
use App\Models\Vendor;
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
    public function create(VendorStoreRequest $request)
    {
        $add = Vendor::create([
            'name' =>$request->name,
            'address' =>$request->address,
            'phone_no' =>$request->phone_no,
        ]);
        if($add){
            return redirect(route('vendor'));
        }
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
    public function updateVendor($id)
    {
        $vendor = Vendor::where('id',$id)->first();
        return view('pages.Vendor.updateVendor',compact('vendor'));
    }
    public function update(VendorUpdateRequest $request,$id)
    {

        $update = Vendor::where('id',$id)->update([
            'name' => $request->name,
            'address' =>$request->address,
            'phone_no' =>$request->phone_no,
        ]);
        if($update){
            return redirect(route('vendor'));
        }
    }
    public function delete($id)
    {
        $delete = Vendor::where('id',$id)->delete();
        if($delete){
            return redirect(route('vendor'));
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brands)
    {
        //
    }
}
