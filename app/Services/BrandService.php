<?php

namespace App\Services;

use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandService
{
    public function __construct(private readonly BrandRepositoryInterface $brandRepository)
    {

    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->brandRepository->create($data);
    }

    public function getBrand()
    {
        return $this->brandRepository->getAllPaginate(6);
    }

    public function getAll()
    {
        return $this->brandRepository->all();
    }

    public function getBrandById($id)
    {
        return $this->brandRepository->findById($id);
    }

    public function updateBrand($request, $id)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        $this->brandRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->brandRepository->destroy($id);
    }

    public function searchContent($request)
    {
        return $this->brandRepository->search($request);
    }
}
