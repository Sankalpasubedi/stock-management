<?php

namespace App\Services;

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
        return $this->customerRepository->findById($id);
    }

    public function createCustomerBill($request)
    {
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
        return $this->customerRepository->createBill($customerMain, $data);

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
