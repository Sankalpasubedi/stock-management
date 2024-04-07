<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Http\Requests\SalesStoreRequest;
use App\Http\Requests\SalesUpdateRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ReturnedProduct;
use App\Models\Vendor;
use App\Services\BillService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\ReturnedService;
use App\Services\VendorService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    use SuccessMessage;

    /**
     * Display a listing of the resource.
     */
    public function addPurchase(VendorService  $vendorService,
                                ProductService $productService)
    {
        $vendors = $vendorService->getAll();
        $products = $productService->getAll();
        return view('pages.Bills.addPurchase', compact('vendors', 'products'));
    }


    public function searchBill(BillService $billService, Request $request)
    {

        $bills = $billService->searchContent($request);

        return view('pages.bill', compact('bills'));

    }

    public function paidBill(BillService $billService, $id)
    {
        try {
            DB::beginTransaction();
            $billService->creditAmountPaid($id);
            DB::commit();
            $this->getTaskSuccessMessage('Bill Payed');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    public function saveBillPurchase(BillService   $billService,
                                     VendorService $vendorService,
                                     Request       $request,
                                                   $id)
    {
        try {
            DB::beginTransaction();
            $billService->updatePurchaseBill($id, $request, $vendorService);
            DB::commit();
            $this->getUpdateSuccessMessage('Bill');
            return redirect(route('bill'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function saveBillSales(BillService     $billService,
                                  CustomerService $customerService,
                                  Request         $request, $id)
    {
        try {
            DB::beginTransaction();
            $billService->updateSalesBill($id, $request, $customerService);
            DB::commit();
            $this->getUpdateSuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function previewBill(BillService $billService, $id)
    {
        $billCalculations = $billService->getBillAmounts($id);
        list($mainBill, $total, $taxableAmount, $subProducts, $discountAmt, $vatAmt) = $billCalculations;
        return view('pages.Bills.previewBill', compact('mainBill', 'total', 'taxableAmount', 'subProducts', 'discountAmt', 'vatAmt'));
    }

    public function returnProduct(BillService     $billService,
                                  ProductService  $productService,
                                  VendorService   $vendorService,
                                  CustomerService $customerService,
                                  ReturnedService $returnedService,
                                                  $id)
    {

        try {
            DB::beginTransaction();
            $billService->returnBill($productService, $vendorService, $customerService, $returnedService, $id);
            DB::commit();
            $this->getTaskSuccessMessage('Bill Returned');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    public function createSales(BillService       $billService,
                                CustomerService   $customerService,
                                ProductService    $productService,
                                SalesStoreRequest $request)
    {

        try {
            DB::beginTransaction();
            $customerService->createCustomerBill($billService, $productService, $request);
            DB::commit();
            $this->getSuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('addSales'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function createPurchase(BillService          $billService,
                                   VendorService        $vendorService,
                                   ProductService       $productService,
                                   PurchaseStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $vendorService->createVendorBillProducts($request, $productService, $billService);
            DB::commit();
            $this->getSuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function updatePurchase(BillService    $billService,
                                   ProductService $productService,
                                                  $id, $stock, $price)
    {
        $bill = $billService->getBillById($id);
        $products = $productService->getAll();
        return view('pages.Bills.updatePurchase', compact('bill', 'price', 'stock', 'id', 'products'));
    }

    public function updateBillPurchase(BillService    $billService,
                                       ProductService $productService,
                                       VendorService  $vendorService,
                                                      $id)
    {
        $bill = $billService->getBillById($id);
        $subBills = $billService->getSubBillById($id);
        $products = $productService->getAll();
        $vendors = $vendorService->getAll();
        return view('pages.Bills.updateBillPurchase', compact('bill', 'subBills', 'id', 'products', 'vendors'));
    }

    public function updateBillSales(BillService     $billService,
                                    ProductService  $productService,
                                    CustomerService $customerService,
                                                    $id)
    {
        $bill = $billService->getBillById($id);
        $subBills = $billService->getSubBillById($id);
        $products = $productService->getAll();
        $customers = $customerService->getAll();

        return view('pages.Bills.updateBillSales', compact('bill', 'subBills', 'id', 'products', 'customers'));
    }

    public function savePurchase(BillService           $billService,
                                 ProductService        $productService,
                                 PurchaseUpdateRequest $request, $id, $stock)
    {
        try {
            DB::beginTransaction();
            $billService->updateSubBillPurchase($id, $request, $productService, $stock);
            DB::commit();
            $this->getUpdateSuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }


    public function updateSales(BillService    $billService,
                                ProductService $productService,
                                               $id, $stock, $price)
    {
        $bill = $billService->getBillById($id);
        $products = $productService->getAll();
        return view('pages.Bills.updateSales', compact('bill', 'price', 'stock', 'id', 'products'));
    }

    public function saveSales(BillService        $billService,
                              ProductService     $productService,
                              SalesUpdateRequest $request, $id, $stock)
    {
        try {
            DB::beginTransaction();
            $billService->updateSubBillSales($id, $request, $productService, $stock);
            DB::commit();
            $this->getUpdateSuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }


    public function addSales(CustomerService $customerService,
                             ProductService  $productService)
    {
        $customers = $customerService->getAll();
        $products = $productService->getAll();
        return view('pages.Bills.addSales', compact('customers', 'products'));
    }


    public function delete(BillService $billService, $id)
    {
        try {
            DB::beginTransaction();
            $billService->deleteBill($id);
            DB::commit();
            $this->getDestroySuccessMessage('Bill');
            return redirect(route('bill'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('bill'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    public function deleteSubBill(BillService    $billService,
                                  ProductService $productService,
                                  VendorService  $vendorService,
                                                 $id)
    {
        try {
            DB::beginTransaction();
            $data = $billService->deleteSubBillsPurchase($productService, $vendorService, $id);
            [$bill, $subBills, $products, $vendors] = $data;
            DB::commit();
            $this->getDestroySuccessMessage('Sub Bill');
            return view('pages.Bills.updateBillPurchase', compact('bill', 'subBills', 'products', 'vendors'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    public function deleteSubBillSales(BillService     $billService,
                                       ProductService  $productService,
                                       CustomerService $customerService,
                                                       $id)
    {
        try {
            DB::beginTransaction();
            $data = $billService->deleteSubBillsSales($productService, $customerService, $id);
            [$bill, $subBills, $products, $customers] = $data;
            DB::commit();
            $this->getDestroySuccessMessage('Sub Bill');
            return view('pages.Bills.updateBillSales', compact('bill', 'subBills', 'id', 'products', 'customers'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }
}
