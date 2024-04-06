<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {

    }

    public function addCategory($request)
    {
        $data = [
            'name' => $request->name
        ];
        $this->categoryRepository->create($data);
    }

    public function getCategory()
    {
        return $this->categoryRepository->getAllPaginate(6);
    }

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function updateCategory($request, $id)
    {
        $this->categoryRepository->update($id, [
            'name' => $request->name
        ]);
    }

    public function delete($id)
    {
        $this->categoryRepository->destroy($id);
    }

    public function searchContent($request)
    {
        return $this->categoryRepository->search($request);
    }
}
