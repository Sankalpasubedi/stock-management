<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;

class BillController extends Controller
{
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
        $billService->creditAmountPaid($id);
        return redirect(route('bill'));
    }

    public function saveBillPurchase(BillService   $billService,
                                     VendorService $vendorService,
                                     Request       $request,
                                                   $id)
    {
        $vendor = $vendorService->getVendorById($request->vendor);
        $billService->updatePurchaseBill($id, $request, $vendor);
        return redirect(route('bill'))->with('success', 'Bill updated successfully.');

    }

    public function saveBillSales(BillService     $billService,
                                  CustomerService $customerService,
                                  Request         $request, $id)
    {
        $customer = $customerService->getCustomerById($request->customer);
        $billService->updateSalesBill($id, $request, $customer);;
        return redirect(route('bill'))->with('success', 'Bill updated successfully.');

    }

    public function previewBill(BillService $billService, $id)
    {

        $mainBill = $billService->getBillById($id);
        $billCalculations = $billService->getBillAmounts($id, $mainBill);
        list($total, $taxableAmount, $subProducts, $discountAmt, $vatAmt) = $billCalculations;
        return view('pages.Bills.previewBill', compact('mainBill', 'total', 'taxableAmount', 'subProducts', 'discountAmt', 'vatAmt'));
    }

    public function returnProduct(BillService     $billService,
                                  ProductService  $productService,
                                  VendorService   $vendorService,
                                  CustomerService $customerService,
                                  ReturnedService $returnedService,
                                                  $id)
    {
        $bill = $billService->getBillById($id);
        $billUnders = $billService->getSubBillById($id);

//        Remaining
        foreach ($billUnders as $billUnder) {
            $product = Product::where('id', $billUnder->product_id)->first();
            if ($product->current_stock - $billUnder->stock < 0) {
                return redirect()->back()->withErrors(['error' => 'Stock is less than what we need to return', $product->name]);
            }
        }
        $billService->returnBill($productService, $vendorService, $customerService, $returnedService, $billUnders, $bill);
        return redirect(route('bill'));
    }

    public function createSales(BillService       $billService,
                                CustomerService   $customerService,
                                ProductService    $productService,
                                SalesStoreRequest $request)
    {

        $productIds = $request->input('product');
        $productStocks = $request->input('stock');

//        Remaining
        foreach ($productIds as $index => $productId) {
            $stock = Product::where('id', $productId)->first();
            if ($productStocks[$index] > $stock->current_stock) {
                return redirect()->back()->withErrors(['error' => 'Quantity exceeds the amount of stock we have on', $stock->name]);
            }
        }


        $customerService->createCustomerBill($request);
        $mainBillId = $billService->getMainBill($request);
        $customerService->createCustomerBillProducts($request, $productService, $mainBillId);
        return redirect(route('bill'));

    }

    public function createPurchase(BillService          $billService,
                                   VendorService        $vendorService,
                                   ProductService       $productService,
                                   PurchaseStoreRequest $request)
    {

        $vendorService->createVendorBill($request);
        $mainBillId = $billService->getMainBill($request);
        $vendorService->createVendorBillProducts($request, $productService, $mainBillId);
        return redirect(route('bill'));
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
        $fetchData = $billService->getBillPriceStockById($id, $request, $stock);
        list($fetch, $changedPrice, $changedStock) = $fetchData;
        $mainBillData = $billService->getBillById($fetch->bill_under);
        $subBillsData = $billService->getSubBillById($mainBillData->id);
        $productService->decrementStock($changedStock, $request->product);
        $billService->decrementTotal($changedPrice, $fetch->bill_under, $mainBillData, $subBillsData);
        $billService->updateSubBill($id, $request);
        return redirect(route('bill'));
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
        $fetchData = $billService->getBillPriceStockById($id, $request, $stock);
        list($fetch, $changedPrice, $changedStock) = $fetchData;
        $mainBillData = $billService->getBillById($fetch->bill_under);
        $subBillsData = $billService->getSubBillById($mainBillData->id);
//        Remaining
        $product = Product::where('id', $request->product)->first();
        if ($product->current_stock + $stock < $request->stock) {
            return redirect()->back()->withErrors(['error' => 'Quantity exceeds the amount of stock we have on']);
        }
        $productService->incrementStock($changedStock, $request->product);
        $billService->decrementTotal($changedPrice, $fetch->bill_under, $mainBillData, $subBillsData);
        $billService->updateSubBill($id, $request);
        return redirect(route('bill'));
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
        $billService->deleteBill($id);
        return redirect(route('bill'));

    }

    public function deleteSubBill(BillService    $billService,
                                  ProductService $productService,
                                  VendorService  $vendorService,
                                                 $id)
    {
        $fetch = $billService->getBillById($id);
        //        Remaining
        $product = Product::where('id', $fetch->product_id)->first();
        if ($product->current_stock - $fetch->stock < 0) {
            return redirect()->back()->withErrors(['error' => 'Stock Underflow']);
        }
        $productService->decrementStock($fetch->stock, $fetch->product_id);
        $mainBillData = $billService->getBillById($fetch->bill_under);
        $subBillsData = $billService->getSubBillById($mainBillData->id);
        $billService->decrementTotal($fetch->total_product_amount, $fetch->bill_under, $mainBillData, $subBillsData);
        $bill = $billService->getBillById($fetch->bill_under);
        $billService->deleteBill($id);
        $subBills = $billService->getSubBillById($fetch->bill_under);
        $products = $productService->getAll();
        $vendors = $vendorService->getAll();

        return view('pages.Bills.updateBillPurchase', compact('bill', 'subBills', 'id', 'products', 'vendors'));
    }

    public function deleteSubBillSales(BillService     $billService,
                                       ProductService  $productService,
                                       CustomerService $customerService,
                                                       $id)
    {
        $fetch = $billService->getBillById($id);
        $productService->incrementStock($fetch->stock, $fetch->product_id);
        $mainBillData = $billService->getBillById($fetch->bill_under);
        $subBillsData = $billService->getSubBillById($mainBillData->id);
        $billService->decrementTotal($fetch->total_product_amount, $fetch->bill_under, $mainBillData, $subBillsData);
        $bill = $billService->getBillById($fetch->bill_under);
        $billService->deleteBill($id);
        $subBills = $billService->getSubBillById($bill->id);
        $products = $productService->getAll();
        $customers = $customerService->getAll();

        return view('pages.Bills.updateBillSales', compact('bill', 'subBills', 'id', 'products', 'customers'));
    }
}
