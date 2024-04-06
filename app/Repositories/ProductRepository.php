<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate(int $paginate)
    {
        return $this->model->paginate($paginate);
    }

    public function search(Request $request)
    {
        $productName = $request->searchProduct;
        return $this->model->where('name', 'like', '%' . $productName . '%')
            ->with(['brand' => fn($q) => $q->select(['id', 'name'])])
            ->with(['unit' => fn($q) => $q->select(['id', 'name'])])
            ->paginate(6);

    }

    public function getProductById($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->with(['category', 'brand', 'unit'])->where('id', $id)->first();;
    }

    public function increment($stockAmounts, $productName)
    {
        return $this->model->where('id', $productName)->increment('current_stock', $stockAmounts);
    }

    public function decrement($stockAmounts, $productName)
    {
        return $this->model->where('id', $productName)->decrement('current_stock', $stockAmounts);
    }

}
