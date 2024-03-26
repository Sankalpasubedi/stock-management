<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addUnit()
    {
        return view('pages.Unit.addUnit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(UnitStoreRequest $request)
    {
        Unit::create([
            'name' => $request->name
        ]);
        return redirect(route('unit'));
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

    public function updateUnit($id)
    {
        $unit = Unit::where('id', $id)->first();
        return view('pages.Unit.updateUnit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitUpdateRequest $request, $id)
    {

        Unit::where('id', $id)->update([
            'name' => $request->name
        ]);
        return redirect(route('unit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Unit::where('id', $id)->delete();
        return redirect(route('unit'));
    }

    public function destroy(Category $categories)
    {
        //
    }
}
