<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ReturnedProduct;
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

    public function paidReturn($id)
    {
        ReturnedProduct::where('id', $id)->update([
            'payable' => null,
            'receivable' => null,
            'bill_end_date' => null
        ]);
        return redirect(route('return'));
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

    public function deleteReturned($id)
    {
        ReturnedProduct::where('id', $id)->orWhere('bill_under', $id)->delete();
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
