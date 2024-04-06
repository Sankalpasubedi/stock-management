<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ReturnedProduct;
use App\Services\ReturnedService;
use Illuminate\Http\Request;

class ReturnedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function paidReturn(ReturnedService $returnedService, $id)
    {
        $returnedService->creditAmountPaid($id);
        return redirect(route('return'));
    }

    public function searchReturn(ReturnedService $returnedService, Request $request)
    {
        $returns = $returnedService->searchContent($request);


        return view('pages.returned', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(ReturnedProduct $returnedProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnedProduct $returnedProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturnedProduct $returnedProduct)
    {
        //
    }

    public function deleteReturned(ReturnedService $returnedService, $id)
    {
        $returnedService->deleteReturnedProducts($id);
        return redirect(route('return'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnedProduct $returnedProduct)
    {
        //
    }
}
