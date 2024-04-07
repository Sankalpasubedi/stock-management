<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Clockwork\Request\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $categoryService->addCategory($request);
            DB::commit();
            $this->getSuccessMessage('Category');
            return redirect(route('category'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('category'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

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
        try {
            DB::beginTransaction();
            $categoryService->updateCategory($request, $id);
            DB::commit();
            $this->getUpdateSuccessMessage('Category');
            return redirect(route('category'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('category'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CategoryService $categoryService, $id)
    {
        try {
            DB::beginTransaction();
            $categoryService->delete($id);
            DB::commit();
            $this->getDestroySuccessMessage('Category');
            return redirect(route('category'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('category'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

    public function searchCategory(CategoryService $categoryService, Request $request)
    {
        $categories = $categoryService->searchContent($request);
        return view('pages.categories', compact('categories'));

    }
}
