<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Vendor;
use App\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
{
    public function __construct(Vendor $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }

    public function search(Request $request)
    {
        $vendorName = $request->searchVendor;
        return $this->model->where('name', 'like', '%' . $vendorName . '%')->paginate(6);
    }

    public function findFirstById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function createBill($vendorMain, $data)
    {
        return $vendorMain->bill()->create($data);
    }

    public function createReturn($vendorMain, $data)
    {
        return $vendorMain->return()->create($data);
    }

    public function createBillProduct($vendor, $data)
    {
        return $vendor->bill()->create($data);
    }


}
