<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Brand;
use App\Models\Vendor;
use App\Services\VendorService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class VendorController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $vendorService->createVendor($request);
            DB::commit();
            $this->getSuccessMessage('Vendor');
            return redirect(route('vendor'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('vendor'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


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
        try {
            DB::beginTransaction();
            $vendorService->updateVendor($request, $id);
            DB::commit();
            $this->getUpdateSuccessMessage('Vendor');
            return redirect(route('vendor'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('vendor'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function searchVendor(VendorService $vendorService, Request $request)
    {
        $vendors = $vendorService->searchContent($request);
        return view('pages.vendors', compact('vendors'));
    }

    public function delete(VendorService $vendorService, $id)
    {
        try {
            DB::beginTransaction();
            $vendorService->delete($id);
            DB::commit();
            $this->getDestroySuccessMessage('Vendor');
            return redirect(route('vendor'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('vendor'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

}
