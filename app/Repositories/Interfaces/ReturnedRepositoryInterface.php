<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface ReturnedRepositoryInterface
{
    public function getAllPaginate(int $paginate);

    public function search(Request $request);

    public function getData($bill_no);

    public function deleteAll($id);
}
