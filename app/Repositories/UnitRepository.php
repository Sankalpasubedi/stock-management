<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Unit;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UnitRepository extends BaseRepository implements UnitRepositoryInterface
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    public function search(Request $request)
    {
        $unitName = $request->searchUnit;
        return $this->model->where('name', 'like', '%' . $unitName . '%')->paginate(6);

    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }
}
