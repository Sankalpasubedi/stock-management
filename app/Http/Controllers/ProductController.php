<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addProduct()
    {
        $categories = Category::get();
        $brand = Brand::get();
        $unit = Unit::get();
        return view('pages.Product.addProducts', compact('categories','brand','unit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductStoreRequest $request)
    {
        $add = Product::create([
            'name' =>$request->name,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'current_stock' => 0,
            'price' => $request->price,
            'unit_id' => $request->unit,
        ]);
        if($add){
            return redirect(route('product'));
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
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $categories)
    {
        //
    }

    public function updateProduct($id)
    {
        $product = Product::where('id',$id)->first();
        $categories = Category::get();
        $brand = Brand::get();
        $unit = Unit::get();
        return view('pages.Product.updateProducts',compact('product','categories','brand','unit'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request,$id)
    {

        $update = Product::where('id',$id)->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'current_stock' => $request->stock,
            'price' => $request->price,
            'unit_id' => $request->unit,
        ]);
        if($update){
            return redirect(route('product'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $delete = Product::where('id',$id)->delete();
        if($delete){
            return redirect(route('product'));
        }
    }
    public function destroy(Category $categories)
    {
        //
    }
}
