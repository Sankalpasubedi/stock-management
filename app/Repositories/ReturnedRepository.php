<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Customer;
use App\Models\ReturnedProduct;
use App\Models\Vendor;
use App\Repositories\Interfaces\ReturnedRepositoryInterface;
use Illuminate\Http\Request;

class ReturnedRepository extends BaseRepository implements ReturnedRepositoryInterface
{
    public function __construct(ReturnedProduct $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->with(['returnable', 'product'])->where('bill_under', null)->paginate($paginate);
    }

    public function search(Request $request)
    {
        $returnName = $request->searchReturn;
        return $this->model->with(['returnable', 'product'])
            ->where('bill_under', null)
            ->where(function ($query) use ($returnName) {
                $query->where('bill_no', 'like', "%$returnName%")
                    ->orWhereHasMorph('returnable', [Customer::class], function ($query) use ($returnName) {
                        $query->where('name', 'LIKE', "%$returnName%");
                    })
                    ->orWhereHasMorph('returnable', [Vendor::class], function ($query) use ($returnName) {
                        $query->where('name', 'LIKE', "%$returnName%");
                    });
            })
            ->paginate(10);
    }

    public function getData($bill_no)
    {
        return $this->model->where('bill_no', $bill_no)->first()->id;
    }

    public function deleteAll($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->where('id', $id)->orWhere('bill_under', $id)->delete();
    }
}
