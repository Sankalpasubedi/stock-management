<?php

namespace App\Services;

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

    public function updateSubBill($id, $request)
    {
        $data = [
            'total_product_amount' => $request->total,
            'rate' => $request->rate,
            'stock' => $request->stock,
            'product_id' => $request->product,

        ];
        return $this->billRepository->update($id, $data);
    }

    public function updatePurchaseBill($id, $request, $vendor)
    {
        $data = [
            'billable_id' => $vendor->id,
            'payable' => $request->payable ?? null,
            'bill_no' => $request->billNum,
            'bill_end_date' => $request->date ?? null,
        ];

        return $this->billRepository->update($id, $data);
    }

    public function updateSalesBill($id, $request, $customer)
    {
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

    public function getBillAmounts($id, $mainBill)
    {
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
        return [$total, $taxableAmount, $subProducts, $discountAmt, $vatAmt];
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
                                               $subProducts, $bill)
    {

        if ($bill->billable_type === 'vendor') {
            $vendorService->createVendorReturn($bill);
            $returnVendorId = $returnedService->getFromBillNo($bill->bill_no);
            $vendorService->createVendorReturnProducts($productService, $subProducts, $returnVendorId, $bill);
            return $this->billRepository->deleteAllBills($bill->id);
        } elseif ($bill->billable_type === 'customer') {


            $customerMain = Customer::where('id', $bill->billable_id)->first();
            $customerMain->return()->create([
                'receivable' => $bill->receivable ?? null,
                'total_bill_amount' => $bill->total_bill_amount,
                'bill_no' => $bill->bill_no,
                'bill_under' => null,
                'bill_end_date' => $bill->bill_end_date ?? null,
            ]);

            if ($customerMain) {
                $returnId = ReturnedProduct::where('bill_no', $bill->bill_no)->first()->id;
                $subProducts = Bill::where('bill_under', $id)->get();
                foreach ($subProducts as $subProduct) {
                    Product::where('id', $subProduct->product_id)->increment('current_stock', $subProduct->stock);
                    $customer = Customer::where('id', $bill->billable_id)->first();
                    $customer->return()->create([
                        'total_product_amount' => $subProduct->total_product_amount ?? null,
                        'bill_no' => $subProduct->bill_no ?? null,
                        'rate' => $subProduct->rate ?? null,
                        'stock' => $subProduct->stock ?? null,
                        'bill_under' => $returnId,
                        'product_id' => $subProduct->product_id ?? null,
                    ]);

                }
                Bill::where('bill_under', $id)->delete();
                return $bill->delete();
            }


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

    public function addBill($request)
    {

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
