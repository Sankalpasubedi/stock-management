<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ReturnedProduct;
use App\Models\Vendor;
use App\Repositories\Interfaces\BillRepositoryInterface;

class BillService
{

    public function __construct(private readonly BillRepositoryInterface $billRepository)
    {

    }

    public function creditAmountPaid($id)
    {
        $data = [
            'payable' => null,
            'receivable' => null,
            'bill_end_date' => null
        ];
        $this->billRepository->update($id, $data);
    }

    public function updateSubBillPurchase($id, $request,
                                          ProductService $productService, $stock)
    {
        $fetchData = $this->getBillPriceStockById($id, $request, $stock);
        list($fetch, $changedPrice, $changedStock) = $fetchData;
        $mainBillData = $this->getBillById($fetch->bill_under);
        $subBillsData = $this->getSubBillById($mainBillData->id);
        $productService->decrementStock($changedStock, $request->product);
        $this->decrementTotal($changedPrice, $fetch->bill_under, $mainBillData, $subBillsData);
        $data = [
            'total_product_amount' => $request->total,
            'rate' => $request->rate,
            'stock' => $request->stock,
            'product_id' => $request->product,

        ];
        return $this->billRepository->update($id, $data);
    }

    public function updateSubBillSales($id, $request,
                                       ProductService $productService, $stock)
    {

        $fetchData = $this->getBillPriceStockById($id, $request, $stock);
        list($fetch, $changedPrice, $changedStock) = $fetchData;
        $mainBillData = $this->getBillById($fetch->bill_under);
        $subBillsData = $this->getSubBillById($mainBillData->id);
        $product = $productService->getProductById($request->product);
        if ($product->current_stock + $stock < $request->stock) {
            throw new CustomException("Quantity exceeds the amount of stock we have on");
        }
        $productService->incrementStock($changedStock, $request->product);
        $this->decrementTotal($changedPrice, $fetch->bill_under, $mainBillData, $subBillsData);
        $data = [
            'total_product_amount' => $request->total,
            'rate' => $request->rate,
            'stock' => $request->stock,
            'product_id' => $request->product,

        ];
        return $this->billRepository->update($id, $data);
    }

    public function updatePurchaseBill($id, $request,
                                       VendorService $vendorService)
    {
        $vendor = $vendorService->getVendorById($request->vendor);
        $data = [
            'billable_id' => $vendor->id,
            'payable' => $request->payable ?? null,
            'bill_no' => $request->billNum,
            'bill_end_date' => $request->date ?? null,
        ];

        return $this->billRepository->update($id, $data);
    }

    public function updateSalesBill($id, $request,
                                    CustomerService $customerService)
    {
        $customer = $customerService->getCustomerById($request->customer);
        $data = [
            'billable_id' => $customer->id,
            'receivable' => $request->receivable ?? null,
            'bill_no' => $request->billNum,
            'bill_end_date' => $request->date ?? null,
        ];

        return $this->billRepository->update($id, $data);
    }

    public function validateBill($request)
    {
        $billNoms = $this->billRepository->all();
        foreach ($billNoms as $billNom) {
            if ($billNom->bill_no === $request->billNum) {
                return true;
            }

        }
    }

    public function getMainBill($request)
    {
        return $this->billRepository->getBillThroughBillNum($request);
    }

    public function getBills()
    {
        return $this->billRepository->getAllPaginate(6);
    }

    public function getBillAmounts($id)
    {
        $mainBill = $this->getBillById($id);

        $subProducts = $this->billRepository->getById($id);
        $total = 0;
        foreach ($subProducts as $subProduct) {
            $total += $subProduct->total_product_amount;
        }
        if ($mainBill->discount_percentage > 0) {
            $discountAmt = $total * ($mainBill->discount_percentage / 100);
        } elseif ($mainBill->discount_amount > 0) {
            $discountAmt = $mainBill->discount_amount;
        } else {
            $discountAmt = 0;
        }
        if ($mainBill->vat === 1) {
            $discountTotal = $total - $discountAmt;
            $vatAmt = $discountTotal * (13 / 100);
        } else {
            $vatAmt = 0;
        }
        $taxableAmount = $total - $discountAmt;
        return [$mainBill, $total, $taxableAmount, $subProducts, $discountAmt, $vatAmt];
    }

    public function getBillById($id)
    {
        return $this->billRepository->findById($id);
    }

    public function getBillPriceStockById($id, $request, $stock)
    {
        $fetch = $this->billRepository->findById($id);
        $changedPrice = $fetch->total_product_amount - $request->total;
        $changedStock = $stock - $request->stock;
        return [$fetch, $changedPrice, $changedStock];
    }

    public function decrementTotal($changedPrice, $billId, $mainBillData, $subBillsData)
    {
        $subAmountsCalculated = 0;
        foreach ($subBillsData as $subBillDatum) {
            $subAmountsCalculated = $subAmountsCalculated + $subBillDatum->total_product_amount;
        }
        if ($mainBillData->vat > 0) {
            if ($mainBillData->discount_amount > 0) {
                $totalValue = ($subAmountsCalculated - $changedPrice) - $mainBillData->discount_amount;
            } elseif ($mainBillData->discount_percentage > 0) {
                $totalValuePercentage = ($subAmountsCalculated - $changedPrice);
                $totalValue = $totalValuePercentage - ($totalValuePercentage * ($mainBillData->discount_percentage / 100));
            } else {
                $totalValue = ($subAmountsCalculated - $changedPrice);
            }
            $totalWithVat = $totalValue + ($totalValue * (13 / 100));
            $data = [
                'total_bill_amount' => $totalWithVat
            ];
            return $this->billRepository->updateTotalBillAmount($data, $billId);
        } else {
            if ($mainBillData->discount_amount > 0) {
                $totalValue = ($subAmountsCalculated - $changedPrice) - $mainBillData->discount_amount;
            } elseif ($mainBillData->discount_percentage > 0) {
                $totalValuePercentage = ($subAmountsCalculated - $changedPrice);
                $totalValue = $totalValuePercentage - ($totalValuePercentage * ($mainBillData->discount_percentage / 100));
            } else {
                $totalValue = ($subAmountsCalculated - $changedPrice);
            }
            $totalWithoutVat = $totalValue;
            $data = [
                'total_bill_amount' => $totalWithoutVat
            ];
            return $this->billRepository->updateTotalBillAmount($data, $billId);
        }
    }


    public function returnBill(ProductService  $productService,
                               VendorService   $vendorService,
                               CustomerService $customerService,
                               ReturnedService $returnedService,
                                               $id)
    {
        $bill = $this->getBillById($id);
        $subProducts = $this->getSubBillById($id);

        if ($bill->billable_type === 'vendor') {
            foreach ($subProducts as $billUnder) {
                $product = $productService->getProductById($billUnder->product_id);
                if ($product->current_stock - $billUnder->stock < 0) {
                    throw new CustomException("Stock is less than what we need to return");
                }
            }
            $vendorService->createVendorReturn($bill);
            $returnVendorId = $returnedService->getFromBillNo($bill->bill_no);
            $vendorService->createVendorReturnProducts($productService, $subProducts, $returnVendorId, $bill);
            return $this->billRepository->deleteAllBills($bill->id);
        } elseif ($bill->billable_type === 'customer') {
            $customerService->createCustomerReturn($bill);
            $returnCustomerId = $returnedService->getFromBillNo($bill->bill_no);
            $customerService->createCustomerReturnProducts($productService, $subProducts, $returnCustomerId, $bill);
            return $this->billRepository->deleteAllBills($bill->id);


        }
    }

    public function getSubBillById($id)
    {
        return $this->billRepository->findSubBillsById($id);
    }

    public function validateStock($billUnders)
    {
    }

    public function getAll()
    {
        return $this->billRepository->all();
    }

    public function deleteSubBillsSales(ProductService  $productService,
                                        CustomerService $customerService,
                                                        $id)
    {
        $fetch = $this->getBillById($id);
        $productService->incrementStock($fetch->stock, $fetch->product_id);
        $mainBillData = $this->getBillById($fetch->bill_under);
        $subBillsData = $this->getSubBillById($mainBillData->id);
        $this->decrementTotal($fetch->total_product_amount, $fetch->bill_under, $mainBillData, $subBillsData);
        $bill = $this->getBillById($fetch->bill_under);
        $this->deleteBill($id);
        $subBills = $this->getSubBillById($bill->id);
        $products = $this->getAll();
        $customers = $this->getAll();
        return [$bill, $subBills, $products, $customers];
    }

    public function deleteSubBillsPurchase(ProductService $productService,
                                           VendorService  $vendorService,
                                                          $id)
    {
        $fetch = $this->getBillById($id);
        $product = $productService->getProductById($fetch->product_id);
        if ($product->current_stock - $fetch->stock < 0) {
            throw new CustomException("Stock Underflow");
        }
        $productService->decrementStock($fetch->stock, $fetch->product_id);
        $mainBillData = $this->getBillById($fetch->bill_under);
        $subBillsData = $this->getSubBillById($mainBillData->id);
        $this->decrementTotal($fetch->total_product_amount, $fetch->bill_under, $mainBillData, $subBillsData);
        $bill = $this->getBillById($fetch->bill_under);
        $this->deleteBill($id);
        $subBills = $this->getSubBillById($fetch->bill_under);
        $products = $this->getAll();
        $vendors = $this->getAll();
        return [$bill, $subBills, $products, $vendors];
    }

    public function searchContent($request)
    {
        return $this->billRepository->search($request);
    }

    public function deleteBill($id)
    {
        $this->billRepository->deleteAllBills($id);
    }
}
