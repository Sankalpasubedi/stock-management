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
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $productService->create($request);
            DB::commit();
            $this->getSuccessMessage('Product');
            return redirect(route('product'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('product'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


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
        try {
            DB::beginTransaction();
            $productService->update($request, $id);
            DB::commit();
            $this->getUpdateSuccessMessage('Product');
            return redirect(route('product'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('product'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }


    public function delete(ProductService $productService, $id)
    {
        try {
            DB::beginTransaction();
            $productService->delete($id);
            DB::commit();
            $this->getDestroySuccessMessage('Product');
            return redirect(route('product'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('product'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function searchProduct(ProductService $productService, Request $request)
    {
        $products = $productService->searchContent($request);
        return view('pages.products', compact('products'));
    }
}
