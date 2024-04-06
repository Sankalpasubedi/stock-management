<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Vendor;
use App\Repositories\Interfaces\BillRepositoryInterface;
use Illuminate\Http\Request;

class BillRepository extends BaseRepository implements BillRepositoryInterface
{

    public function __construct(Bill $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->with(['billable', 'product'])
            ->where('bill_under', null)
            ->paginate($paginate);
    }

    public function search(Request $request)
    {

        $searchTerm = $request->searchBill;
        return $this->model->with(['billable', 'product'])
            ->where('bill_under', null)
            ->where(function ($query) use ($searchTerm) {
                $query->where('bill_no', 'like', "%$searchTerm%")
                    ->orWhereHasMorph('billable', [Customer::class], function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%$searchTerm%");
                    })
                    ->orWhereHasMorph('billable', [Vendor::class], function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%$searchTerm%");
                    });
            })
            ->paginate(10);
    }

    public function getById($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->where('bill_under', $id)->get();
    }

    public function getBillThroughBillNum($request)
    {
        return $this->model->where('bill_no', $request->billNum)->first()->id;
    }

    public function decrement($changedPrice, $billId)
    {
        return $this->model->where('id', $billId)->decrement('total_bill_amount', $changedPrice);
    }

    public function findSubBillsById($id)
    {
        return $this->model->where('bill_under', $id)->get();
    }


    public function updateTotalBillAmount($totalWithVat, $billId)
    {
        return $this->model->where('id', $billId)->update($totalWithVat);
    }

    public function deleteAllBills($id)
    {
        $this->model->where('id', $id)->orWhere('bill_under', $id)->delete();
    }
}
