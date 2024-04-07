<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Category;
use App\Models\Unit;
use App\Services\UnitService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    use SuccessMessage;

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
        try {
            DB::beginTransaction();
            $unitService->create($request);
            DB::commit();
            $this->getSuccessMessage('Unit');
            return redirect(route('unit'));
        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('unit'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


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
        try {
            DB::beginTransaction();
            $unitService->update($request, $id);
            DB::commit();
            $this->getUpdateSuccessMessage('Unit');
            return redirect(route('unit'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('unit'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(UnitService $unitService, $id)
    {
        try {
            DB::beginTransaction();
            $unitService->delete($id);
            DB::commit();
            $this->getDestroySuccessMessage('Unit');
            return redirect(route('unit'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('unit'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

}
