<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function search($request);


}
