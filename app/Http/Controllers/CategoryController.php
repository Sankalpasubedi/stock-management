<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addCategory()
    {
        return view('pages.Category.addCategory');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryService $categoryService, CategoryStoreRequest $request)
    {
        $categoryService->addCategory($request);
        return redirect(route('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $categories)
    {
        //
    }

    public function updateCategory($id, CategoryService $categoryService)
    {
        $category = $categoryService->getCategoryById($id);
        return view('pages.Category.updateCategory', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryService $categoryService, CategoryUpdateRequest $request, $id)
    {
        $categoryService->updateCategory($request, $id);
        return redirect(route('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CategoryService $categoryService, $id)
    {
        $categoryService->delete($id);
        return redirect(route('category'));
    }

    public function destroy(Category $categories)
    {
        //
    }

    public function searchCategory(CategoryService $categoryService, Request $request)
    {
        $categories = $categoryService->searchContent($request);

        return view('pages.categories', compact('categories'));

    }
}
