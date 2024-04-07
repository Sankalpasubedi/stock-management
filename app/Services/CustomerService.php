<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Product;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {

    }

    public function getCustomer()
    {
        return $this->customerRepository->getAllPaginate(6);
    }

    public function getAll()
    {
        return $this->customerRepository->all();
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->findFirstById($id);
    }

    public function createCustomerBill(BillService    $billService,
                                       ProductService $productService,
                                                      $request)
    {
        $productIds = $request->input('product');
        $productStocks = $request->input('stock');
        foreach ($productIds as $index => $productId) {
            $stock = $productService->getProductById($productId);
            if ($productStocks[$index] > $stock->current_stock) {
                throw new CustomException("Quantity exceeds the amount of stock we have on");
            }
        }
        $customerMain = $this->customerRepository->findFirstById($request->customer);
        $data = [
            'receivable' => $request->receivable ?? null,
            'total_bill_amount' => $request->totalBill,
            'bill_no' => $request->billNum,
            'vat' => $request->vat === "on" ? 1 : 0,
            'discount_percentage' => $request->dPercentage ?? null,
            'discount_amount' => $request->dAmount ?? null,
            'bill_under' => null,
            'bill_end_date' => $request->date ?? null,
        ];
        $this->customerRepository->createBill($customerMain, $data);
        $mainBillId = $billService->getMainBill($request);
        $this->createCustomerBillProducts($request, $productService, $mainBillId);
    }

    public function createCustomer($request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->customerRepository->create($data);
    }

    public function updateCustomer($id, $request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->customerRepository->update($id, $data);

    }

    public function deleteCustomer($id)
    {
        $this->customerRepository->destroy($id);
    }

    public function searchContent($request)
    {
        return $this->customerRepository->search($request);
    }

    public function createCustomerReturn($bill)
    {
        $customerMain = $this->getCustomerById($bill->billable_id);
        $data = [
            'receivable' => $bill->receivable ?? null,
            'total_bill_amount' => $bill->total_bill_amount,
            'bill_no' => $bill->bill_no,
            'bill_under' => null,
            'bill_end_date' => $bill->bill_end_date ?? null,
        ];
        return $this->customerRepository->createReturn($customerMain, $data);
    }

    public function createCustomerReturnProducts(ProductService $productService,
                                                                $subProducts,
                                                                $returnCustomerId, $bill)
    {
        foreach ($subProducts as $subProduct) {
            $productService->incrementStock($subProduct->stock, $subProduct->product_id);
            $customer = $this->customerRepository->findFirstById($bill->billable_id);
            $data = [
                'total_product_amount' => $subProduct->total_product_amount ?? null,
                'bill_no' => $subProduct->bill_no ?? null,
                'rate' => $subProduct->rate ?? null,
                'stock' => $subProduct->stock ?? null,
                'bill_under' => $returnCustomerId,
                'product_id' => $subProduct->product_id ?? null,
            ];
            return $this->customerRepository->createReturnProduct($customer, $data);
        }
    }

    public function createCustomerBillProducts($request,
                                               ProductService $productService, $mainBillId)
    {
        $productNames = $request->input('product');
        $totalAmounts = $request->input('total');
        $stockAmounts = $request->input('stock');
        $rateAmounts = $request->input('rate');
        $customer = $this->customerRepository->findFirstById($request->customer);
        foreach ($productNames as $index => $productName) {
            $productService->decrementStock($stockAmounts[$index], $productName);
            $data = [
                'total_product_amount' => $totalAmounts[$index],
                'bill_no' => $request->billNum,
                'rate' => $rateAmounts[$index],
                'stock' => $stockAmounts[$index],
                'bill_under' => $mainBillId,
                'product_id' => $productNames[$index],
            ];
            $this->customerRepository->createBillProduct($customer, $data);
        }
    }
}
