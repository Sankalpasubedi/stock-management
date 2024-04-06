<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function getProductById($id);

    public function search(Request $request);

    public function increment($stockAmounts, $productName);

    public function decrement($stockAmounts, $productName);

}
