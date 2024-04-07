<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function search(Request $request)
    {
        $customerName = $request->searchCustomer;
        return $this->model->where('name', 'like', '%' . $customerName . '%')->paginate(6);

    }

    public function findFirstById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function createBill($customerMain, $data)
    {
        return $customerMain->bill()->create($data);
    }

    public function createBillProduct($customer, $data)
    {
        return $customer->bill()->create($data);
    }

    public function createReturnProduct($customer, $data)
    {
        return $customer->return()->create($data);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }

    public function createReturn($customerMain, $data)
    {
        return $customerMain->return()->create($data);
    }
}
