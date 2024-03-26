<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
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
    public function create(CategoryStoreRequest $request)
    {
        Category::create([
            'name' => $request->name
        ]);
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

    public function updateCategory($id)
    {
        $category = Category::where('id', $id)->first();
        return view('pages.Category.updateCategory', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {

        Category::where('id', $id)->update([
            'name' => $request->name
        ]);
        return redirect(route('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return redirect(route('category'));
    }

    public function destroy(Category $categories)
    {
        //
    }
}
