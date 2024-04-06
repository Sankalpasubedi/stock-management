<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CustomerRepositoryInterface
{
    public function search(Request $request);

    public function createBill($customerMain, $data);

    public function createBillProduct($customer, $data);

    public function findFirstById($id);

}
