<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface UnitRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function search(Request $request);

}
