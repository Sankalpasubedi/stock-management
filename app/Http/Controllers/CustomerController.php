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
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Cassandra\Custom;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $customerService->createCustomer($request);
            DB::commit();
            $this->getSuccessMessage('Customer');
            return redirect(route('customer'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('customer'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


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
        try {
            DB::beginTransaction();
            $customerService->updateCustomer($id, $request);
            DB::commit();
            $this->getUpdateSuccessMessage('Customer');
            return redirect(route('customer'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('customer'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function searchCustomer(CustomerService $customerService, Request $request)
    {
        $customers = $customerService->searchContent($request);
        return view('pages.customer', compact('customers'));
    }

    public function delete(CustomerService $customerService, $id)
    {
        try {
            DB::beginTransaction();
            $customerService->deleteCustomer($id);
            DB::commit();
            $this->getDestroySuccessMessage('Customer');
            return redirect(route('customer'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('customer'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }


}
