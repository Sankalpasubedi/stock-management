<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface BrandRepositoryInterface
{
    public function search(Request $request);
}
