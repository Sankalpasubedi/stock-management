<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function search($request)
    {
        $categoryName = $request->searchCategory;
        return $this->model->where('name', 'like', '%' . $categoryName . '%')->paginate(6);

    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }
}
