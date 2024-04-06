<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\BrandService;
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
    public function create(BrandService $brandService, BrandStoreRequest $request)
    {
        $brandService->create($request);

        return redirect(route('brand'));
    }

    public function searchBrand(BrandService $brandService, Request $request)
    {
        $brands = $brandService->searchContent($request);

        return view('pages.brand', compact('brands'));
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
    public function updateBrand(BrandService $brandService, $id)
    {
        $brand = $brandService->getBrandById($id);
        return view('pages.Brand.updateBrand', compact('brand'));
    }

    public function update(BrandService $brandService, BrandUpdateRequest $request, $id)
    {
        $brandService->updateBrand($request, $id);

        return redirect(route('brand'));

    }

    public function delete(BrandService $brandService, $id)
    {
        $brandService->delete($id);
        return redirect(route('brand'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brands)
    {
        //
    }
}
