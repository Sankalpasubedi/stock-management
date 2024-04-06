<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {

    }

    public function getProduct()
    {
        return $this->productRepository->getAllPaginate(6);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'current_stock' => 0,
            'price' => $request->price,
            'unit_id' => $request->unit,
        ];
        $this->productRepository->create($data);
    }

    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'current_stock' => $request->stock,
            'price' => $request->price,
            'unit_id' => $request->unit,
        ];
        $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->productRepository->destroy($id);
    }

    public function getAll()
    {
        return $this->productRepository->all();
    }

    public function incrementStock($stockAmounts, $productName)
    {
        return $this->productRepository->increment($stockAmounts, $productName);
    }

    public function decrementStock($stockAmounts, $productName)
    {
        return $this->productRepository->decrement($stockAmounts, $productName);
    }

    public function searchContent($request)
    {
        return $this->productRepository->search($request);
    }
}
