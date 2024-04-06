<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface BillRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function search(Request $request);

    public function getById($id);

    public function deleteAllBills($id);

    public function findSubBillsById($id);

    public function decrement($changedPrice, $billId);

    public function getBillThroughBillNum($request);

    public function updateTotalBillAmount($totalWithVat, $billId);
}
