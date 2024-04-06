<?php

namespace App\Services;

use App\Repositories\Interfaces\UnitRepositoryInterface;

class UnitService
{
    public function __construct(private readonly UnitRepositoryInterface $unitRepository)
    {

    }

    public function getUnit()
    {
        return $this->unitRepository->getAllPaginate(6);
    }

    public function getUnitById($id)
    {
        return $this->unitRepository->findById($id);
    }

    public function getAll()
    {
        return $this->unitRepository->all();
    }

    public function searchContent($request)
    {
        return $this->unitRepository->search($request);
    }

    public function create($request)
    {
        $this->unitRepository->create([
            'name' => $request->name
        ]);
    }

    public function update($request, $id)
    {
        $this->unitRepository->update($id, [
            'name' => $request->name
        ]);
    }

    public function delete($id)
    {
        $this->unitRepository->destroy($id);
    }
}
