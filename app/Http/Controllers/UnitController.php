<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Category;
use App\Models\Unit;
use App\Services\UnitService;
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
    public function create(UnitService $unitService, UnitStoreRequest $request)
    {

        $unitService->create($request);
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

    public function updateUnit(UnitService $unitService, $id)
    {
        $unit = $unitService->getUnitById($id);
        return view('pages.Unit.updateUnit', compact('unit'));
    }

    public function searchUnit(UnitService $unitService, Request $request)
    {
        $units = $unitService->searchContent($request);
        return view('pages.units', compact('units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitService $unitService, UnitUpdateRequest $request, $id)
    {
        $unitService->update($request, $id);
        return redirect(route('unit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(UnitService $unitService, $id)
    {
        $unitService->delete($id);
        return redirect(route('unit'));
    }

    public function destroy(Category $categories)
    {
        //
    }
}
