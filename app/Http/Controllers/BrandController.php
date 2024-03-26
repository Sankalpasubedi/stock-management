<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addBrand()
    {
        return view('pages.Brand.addBrand');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(BrandStoreRequest $request)
    {
        $add = Brand::create([
            'name' =>$request->name,
            'address' =>$request->address,
            'phone_no' =>$request->phone_no,
        ]);
        if($add){
            return redirect(route('brand'));
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
    public function updateBrand($id)
    {
        $brand = Brand::where('id',$id)->first();
        return view('pages.Brand.updateBrand',compact('brand'));
    }
    public function update(BrandUpdateRequest $request,$id)
    {

        $update = Brand::where('id',$id)->update([
            'name' => $request->name,
            'address' =>$request->address,
            'phone_no' =>$request->phone_no,
        ]);
        if($update){
            return redirect(route('brand'));
        }
    }
    public function delete($id)
    {
        $delete = Brand::where('id',$id)->delete();
        if($delete){
            return redirect(route('brand'));
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
