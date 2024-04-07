<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Vendor;
use App\Repositories\Interfaces\VendorRepositoryInterface;

class VendorService
{
    public function __construct(private readonly VendorRepositoryInterface $vendorRepository)
    {
    }

    public function getVendor()
    {
        return $this->vendorRepository->getAllPaginate(6);
    }

    public function getAll()
    {
        return $this->vendorRepository->all();
    }

    public function searchContent($request)
    {
        return $this->vendorRepository->search($request);
    }

    public function createVendor($request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->vendorRepository->create($data);
    }

    public function getVendorById($id)
    {
        return $this->vendorRepository->findFirstById($id);
    }

    public function updateVendor($request, $id)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->vendorRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->vendorRepository->destroy($id);
    }

//    Vendor-Bill

    public function createVendorBill($request)
    {
        $vendorMain = $this->vendorRepository->findFirstById($request->vendor);
        $data = [
            'payable' => $request->payable ?? null,
            'total_bill_amount' => $request->totalBill,
            'bill_no' => $request->billNum,
            'vat' => $request->vat === "on" ? 1 : 0,
            'discount_percentage' => $request->dPercentage ?? null,
            'discount_amount' => $request->dAmount ?? null,
            'bill_under' => null,
            'bill_end_date' => $request->date ?? null,
        ];
        return $this->vendorRepository->createBill($vendorMain, $data);

    }

    public function createVendorReturn($bill)
    {
        $vendorMain = $this->vendorRepository->findFirstById($bill->billable_id);
        $data = [
            'payable' => $bill->payable ?? null,
            'total_bill_amount' => $bill->total_bill_amount,
            'bill_no' => $bill->bill_no,
            'bill_under' => null,
            'bill_end_date' => $bill->bill_end_date ?? null,
        ];
        return $this->vendorRepository->createReturn($vendorMain, $data);
    }

    public function createVendorBillProducts($request,
                                             ProductService $productService,
                                             BillService $billService)
    {
        $this->createVendorBill($request);
        $mainBillId = $billService->getMainBill($request);
        $productNames = $request->input('product');
        $totalAmounts = $request->input('total');
        $stockAmounts = $request->input('stock');
        $rateAmounts = $request->input('rate');
        $vendor = $this->vendorRepository->findFirstById($request->vendor);
        foreach ($productNames as $index => $productName) {
            $productService->incrementStock($stockAmounts[$index], $productName);
            $data = [
                'total_product_amount' => $totalAmounts[$index],
                'bill_no' => $request->billNum,
                'rate' => $rateAmounts[$index],
                'stock' => $stockAmounts[$index],
                'bill_under' => $mainBillId,
                'product_id' => $productNames[$index],
            ];
            $this->vendorRepository->createBillProduct($vendor, $data);
        }
    }

    public function createVendorReturnProducts(
        ProductService $productService, $subProducts, $returnVendorId, $bill)
    {
        foreach ($subProducts as $subProduct) {
            $productService->decrementStock($subProduct->stock, $subProduct->product_id);
            $vendor = $this->vendorRepository->findFirstById($bill->billable_id);
            $data = [
                'total_product_amount' => $subProduct->total_product_amount ?? null,
                'bill_no' => $subProduct->bill_no ?? null,
                'rate' => $subProduct->rate ?? null,
                'stock' => $subProduct->stock ?? null,
                'bill_under' => $returnVendorId,
                'product_id' => $subProduct->product_id ?? null,
            ];
            $this->vendorRepository->createReturnProduct($vendor, $data);

        }
    }
}
