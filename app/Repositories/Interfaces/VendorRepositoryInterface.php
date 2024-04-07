<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface VendorRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function search(Request $request);

    public function createBill($vendorMain, $data);

    public function createReturn($vendorMain, $data);

    public function createBillProduct($vendor, $data);

    public function createReturnProduct($vendor, $data);

    public function findFirstById($id);

}
