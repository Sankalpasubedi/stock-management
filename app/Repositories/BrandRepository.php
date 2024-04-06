<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    public function search(Request $request)
    {
        $brandName = $request->searchBrand;
        return $this->model->where('name', 'like', '%' . $brandName . '%')->paginate(6);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }
}
