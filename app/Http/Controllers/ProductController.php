<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UnitService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addProduct(CategoryService $categoryService,
                               BrandService    $brandService,
                               UnitService     $unitService)
    {
        $categories = $categoryService->getall();
        $brands = $brandService->getAll();
        $units = $unitService->getAll();
        return view('pages.Product.addProducts', compact('categories', 'brands', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductService $productService, ProductStoreRequest $request)
    {
        $productService->create($request);
        return redirect(route('product'));
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

    public function updateProduct(ProductService  $productService,
                                  CategoryService $categoryService,
                                  BrandService    $brandService,
                                  UnitService     $unitService,
                                                  $id)
    {
        $product = $productService->getProductById($id);
        $categories = $categoryService->getall();
        $brands = $brandService->getAll();
        $units = $unitService->getAll();
        return view('pages.Product.updateProducts', compact('product', 'categories', 'brands', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductService $productService, ProductUpdateRequest $request, $id)
    {
        $productService->update($request, $id);
        return redirect(route('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(ProductService $productService, $id)
    {
        $productService->delete($id);
        return redirect(route('product'));
    }

    public function destroy(Category $categories)
    {
        //
    }

    public function searchProduct(ProductService $productService, Request $request)
    {
        $products = $productService->searchContent($request);
        return view('pages.products', compact('products'));
    }
}
