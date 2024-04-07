<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\BrandService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;


class BrandController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $brandService->create($request);
            DB::commit();
            $this->getSuccessMessage('Brand');
            return redirect(route('brand'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('brand'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function searchBrand(BrandService $brandService, Request $request)
    {
        $brands = $brandService->searchContent($request);
        return view('pages.brand', compact('brands'));
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
        try {
            DB::beginTransaction();
            $brandService->updateBrand($request, $id);
            DB::commit();
            $this->getUpdateSuccessMessage('Brand');
            return redirect(route('brand'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('brand'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function delete(BrandService $brandService, $id)
    {
        try {
            DB::beginTransaction();
            $brandService->delete($id);
            DB::commit();
            $this->getDestroySuccessMessage('Brand');
            return redirect(route('brand'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('brand'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

}
