<?php

namespace App\Services;

use App\Repositories\Interfaces\ReturnedRepositoryInterface;

class ReturnedService
{
    public function __construct(private readonly ReturnedRepositoryInterface $returnedRepository)
    {

    }

    public function getReturnedProducts()
    {
        return $this->returnedRepository->getAllPaginate(6);
    }

    public function deleteReturnedProducts($id)
    {
        return $this->returnedRepository->deleteAll($id);
    }

    public function creditAmountPaid($id)
    {
        $data = [
            'payable' => null,
            'receivable' => null,
            'bill_end_date' => null
        ];
        $this->returnedRepository->update($id, $data);
    }

    public function getFromBillNo($bill_no)
    {
        return $this->returnedRepository->getData($bill_no);
    }

    public function getAll()
    {
        return $this->returnedRepository->all();
    }

    public function searchContent($request)
    {
        return $this->returnedRepository->search($request);
    }
}
