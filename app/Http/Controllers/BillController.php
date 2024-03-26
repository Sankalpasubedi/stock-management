<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Http\Requests\SalesStoreRequest;
use App\Http\Requests\SalesUpdateRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ReturnedProduct;
use App\Models\Vendor;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addPurchase()
    {
        $vendors = Vendor::get();
        $products = Product::get();
        return view('pages.Bills.addPurchase', compact('vendors', 'products'));
    }

    public function paidBill($id)
    {
        Bill::where('id', $id)->update([
            'payable' => null,
            'receivable' => null,
            'bill_end_date' => null
        ]);
        return redirect(route('bill'));
    }

    public function saveBillPurchase(Request $request, $id)
    {
        $vendor = Vendor::where('id', $request->vendor)->first();
        $bill = Bill::where('id', $id)->update([
            'billable_id' => $vendor->id,
            'payable' => $request->payable ?? null,
            'bill_no' => $request->billNum,
            'bill_end_date' => $request->date ?? null,
        ]);

        if ($bill) {
            return redirect(route('bill'))->with('success', 'Bill updated successfully.');
        } else {
            return back()->with('error', 'Failed to update bill.');
        }
    }

    public function saveBillSales(Request $request, $id)
    {
        $customer = Customer::where('id', $request->customer)->first();
        $bill = Bill::where('id', $id)->update([
            'billable_id' => $customer->id,
            'receivable' => $request->receivable ?? null,
            'bill_no' => $request->billNum,
            'bill_end_date' => $request->date ?? null,
        ]);

        if ($bill) {
            return redirect(route('bill'))->with('success', 'Bill updated successfully.');
        } else {
            return back()->with('error', 'Failed to update bill.');
        }
    }

    public function previewBill($id)
    {
        $mainBill = Bill::where('id', $id)->first();
        $subProducts = Bill::where('bill_under', $id)->get();
        $total = 0;
        foreach ($subProducts as $subProduct) {
            $total += $subProduct->total_product_amount;
        }
        if ($mainBill->discount_percentage > 0) {
            $discountAmt = $total * ($mainBill->discount_percentage / 100);
        } elseif ($mainBill->discount_amount > 0) {
            $discountAmt = $mainBill->discount_amount;
        } else {
            $discountAmt = 0;
        }
        if ($mainBill->vat === 1) {
            $discountTotal = $total - $discountAmt;
            $vatAmt = $discountTotal * (13 / 100);
        } else {
            $vatAmt = 0;
        }
        $taxableAmount = $total - $discountAmt;
        return view('pages.Bills.previewBill', compact('mainBill', 'total', 'taxableAmount', 'subProducts', 'discountAmt', 'vatAmt'));
    }

    public function returnProduct($id)
    {
        $bill = Bill::where('id', $id)->first();
        $billUnders = Bill::where('bill_under', $bill->id)->get();
        foreach ($billUnders as $billUnder) {
            $product = Product::where('id', $billUnder->product_id)->first();
            if ($product->current_stock - $billUnder->stock < 0) {
                return redirect()->back()->withErrors(['error' => 'Stock is less than what we need to return', $product->name]);
            }
        }
        if ($bill->billable_type === 'vendor') {


            $vendorMain = Vendor::where('id', $bill->billable_id)->first();
            $vendorMain->return()->create([
                'payable' => $bill->payable ?? null,
                'total_bill_amount' => $bill->total_bill_amount,
                'bill_no' => $bill->bill_no,
                'bill_under' => null,
                'bill_end_date' => $bill->bill_end_date ?? null,
            ]);

            if ($vendorMain) {
                $returnVendorId = ReturnedProduct::where('bill_no', $bill->bill_no)->first()->id;
                $subProducts = Bill::where('bill_under', $id)->get();
                foreach ($subProducts as $subProduct) {
                    Product::where('id', $subProduct->product_id)->decrement('current_stock', $subProduct->stock);
                    $vendor = Vendor::where('id', $bill->billable_id)->first();
                    $vendor->return()->create([
                        'total_product_amount' => $subProduct->total_product_amount ?? null,
                        'bill_no' => $subProduct->bill_no ?? null,
                        'rate' => $subProduct->rate ?? null,
                        'stock' => $subProduct->stock ?? null,
                        'bill_under' => $returnVendorId,
                        'product_id' => $subProduct->product_id ?? null,
                    ]);

                }
                Bill::where('bill_under', $id)->delete();
                $bill->delete();
                return redirect(route('bill'));
            }


        } elseif ($bill->billable_type === 'customer') {


            $customerMain = Customer::where('id', $bill->billable_id)->first();
            $customerMain->return()->create([
                'receivable' => $bill->receivable ?? null,
                'total_bill_amount' => $bill->total_bill_amount,
                'bill_no' => $bill->bill_no,
                'bill_under' => null,
                'bill_end_date' => $bill->bill_end_date ?? null,
            ]);

            if ($customerMain) {
                $returnId = ReturnedProduct::where('bill_no', $bill->bill_no)->first()->id;
                $subProducts = Bill::where('bill_under', $id)->get();
                foreach ($subProducts as $subProduct) {
                    Product::where('id', $subProduct->product_id)->increment('current_stock', $subProduct->stock);
                    $customer = Customer::where('id', $bill->billable_id)->first();
                    $customer->return()->create([
                        'total_product_amount' => $subProduct->total_product_amount ?? null,
                        'bill_no' => $subProduct->bill_no ?? null,
                        'rate' => $subProduct->rate ?? null,
                        'stock' => $subProduct->stock ?? null,
                        'bill_under' => $returnId,
                        'product_id' => $subProduct->product_id ?? null,
                    ]);

                }
                Bill::where('bill_under', $id)->delete();
                $bill->delete();
                return redirect(route('bill'));
            }


        }
    }

    public function createSales(SalesStoreRequest $request)
    {
        $billNoms = Bill::get();
        foreach ($billNoms as $billNom) {
            if ($billNom->bill_no === $request->billNum) {
                return redirect()->back()->withErrors(['error' => 'Please enter different Bill Number']);
            }
        }
        if ($request->receivable != null) {
            if ($request->totalBill < $request->receivable) {
                return redirect()->back()->withErrors(['error' => 'Credit amount exceeds total amount ']);
            }
        }
        $productIds = $request->input('product');
        $productStocks = $request->input('stock');
        foreach ($productIds as $index => $productId) {
            $stock = Product::where('id', $productId)->first();
            if ($productStocks[$index] > $stock->current_stock) {
                return redirect()->back()->withErrors(['error' => 'Quantity exceeds the amount of stock we have on', $stock->name]);
            }
        }
        $customerMain = Customer::where('id', $request->customer)->first();
        $customerMain->bill()->create([
            'receivable' => $request->receivable ?? null,
            'total_bill_amount' => $request->totalBill,
            'bill_no' => $request->billNum,
            'vat' => $request->vat === "on" ? 1 : 0,
            'discount_percentage' => $request->dPercentage ?? null,
            'discount_amount' => $request->dAmount ?? null,
            'bill_under' => null,
            'bill_end_date' => $request->date ?? null,
        ]);

        if ($customerMain) {
            $mainBillId = Bill::where('bill_no', $request->billNum)->first()->id;
            $productNames = $request->input('product');
            $totalAmounts = $request->input('total');
            $stockAmounts = $request->input('stock');
            $rateAmounts = $request->input('rate');
            $customer = Customer::where('id', $request->customer)->first();
            foreach ($productNames as $index => $productName) {
                Product::where('id', $productName)->decrement('current_stock', $stockAmounts[$index]);
                $customer->bill()->create([
                    'total_product_amount' => $totalAmounts[$index],
                    'bill_no' => $request->billNum,
                    'rate' => $rateAmounts[$index],
                    'stock' => $stockAmounts[$index],
                    'bill_under' => $mainBillId,
                    'product_id' => $productNames[$index],
                ]);

            }
            return redirect(route('bill'));

        }
    }

    public function createPurchase(PurchaseStoreRequest $request)
    {
        $billNoms = Bill::get();
        foreach ($billNoms as $billNom) {
            if ($billNom->bill_no === $request->billNum) {
                return redirect()->back()->withErrors(['error' => 'Please enter different Bill Number']);
            }
        }
        if ($request->payable != null) {
            if ($request->totalBill < $request->payable) {
                return redirect()->back()->withErrors(['error' => 'Credit amount exceeds total amount ']);
            }
        }

        $vendorMain = Vendor::where('id', $request->vendor)->first();
        $vendorMain->bill()->create([
            'payable' => $request->payable ?? null,
            'total_bill_amount' => $request->totalBill,
            'bill_no' => $request->billNum,
            'vat' => $request->vat === "on" ? 1 : 0,
            'discount_percentage' => $request->dPercentage ?? null,
            'discount_amount' => $request->dAmount ?? null,
            'bill_under' => null,
            'bill_end_date' => $request->date ?? null,
        ]);

        if ($vendorMain) {
            $mainBillId = Bill::where('bill_no', $request->billNum)->first()->id;
            $productNames = $request->input('product');
            $totalAmounts = $request->input('total');
            $stockAmounts = $request->input('stock');
            $rateAmounts = $request->input('rate');
            $vendor = Vendor::where('id', $request->vendor)->first();
            foreach ($productNames as $index => $productName) {
                Product::where('id', $productName)->increment('current_stock', $stockAmounts[$index]);
                $vendor->bill()->create([
                    'total_product_amount' => $totalAmounts[$index],
                    'bill_no' => $request->billNum,
                    'rate' => $rateAmounts[$index],
                    'stock' => $stockAmounts[$index],
                    'bill_under' => $mainBillId,
                    'product_id' => $productNames[$index],
                ]);
            }
            return redirect(route('bill'));
        }
    }

    public function updatePurchase($id, $stock, $price)
    {
        $bill = Bill::where('id', $id)->first();
        $products = Product::get();
        return view('pages.Bills.updatePurchase', compact('bill', 'price', 'stock', 'id', 'products'));
    }

    public function updateBillPurchase($id)
    {
        $bill = Bill::where('id', $id)->first();
        $subBills = Bill::where('bill_under', $id)->get();
        $products = Product::get();
        $vendors = Vendor::get();

        return view('pages.Bills.updateBillPurchase', compact('bill', 'subBills', 'id', 'products', 'vendors'));
    }

    public function updateBillSales($id)
    {
        $bill = Bill::where('id', $id)->first();
        $subBills = Bill::where('bill_under', $id)->get();
        $products = Product::get();
        $customers = Customer::get();

        return view('pages.Bills.updateBillSales', compact('bill', 'subBills', 'id', 'products', 'customers'));
    }

    public function savePurchase(PurchaseUpdateRequest $request, $id, $stock)
    {
        $fetch = Bill::where('id', $id)->first();
        $changedPrice = $fetch->total_product_amount - $request->total;
        $changedStock = $stock - $request->stock;
        Product::where('id', $request->product)->decrement('current_stock', $changedStock);
        Bill::where('id', $fetch->bill_under)->decrement('total_bill_amount', $changedPrice);
        Bill::where('id', $id)->update([
            'total_product_amount' => $request->total,
            'rate' => $request->rate,
            'stock' => $request->stock,
            'product_id' => $request->product,
        ]);
        return redirect(route('bill'));
    }


    public function updateSales($id, $stock, $price)
    {
        $bill = Bill::where('id', $id)->first();
        $products = Product::get();
        return view('pages.Bills.updateSales', compact('bill', 'price', 'stock', 'id', 'products'));
    }

    public function saveSales(SalesUpdateRequest $request, $id, $stock)
    {

        $fetch = Bill::where('id', $id)->first();
        $changedPrice = $fetch->total_product_amount - $request->total;
        $changedStock = $stock - $request->stock;
        $product = Product::where('id', $request->product)->first();
        if ($product->current_stock + $stock < $request->stock) {
            return redirect()->back()->withErrors(['error' => 'Quantity exceeds the amount of stock we have on']);
        }
        $product->increment('current_stock', $changedStock);
        Bill::where('id', $fetch->bill_under)->decrement('total_bill_amount', $changedPrice);
        Bill::where('id', $id)->update([
            'total_product_amount' => $request->total,
            'rate' => $request->rate,
            'stock' => $request->stock,
            'product_id' => $request->product,
        ]);
        return redirect(route('bill'));
    }


    public function addSales()
    {
        $customers = Customer::get();
        $products = Product::get();
        return view('pages.Bills.addSales', compact('customers', 'products'));
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
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Bill::where('id', $id)->orWhere('bill_under', $id)->delete();
        return redirect(route('bill'));

    }

    public function deleteSubBill($id)
    {
        $fetch = Bill::where('id', $id)->first();
        Product::where('id', $fetch->product_id)->decrement('current_stock', $fetch->stock);
        Bill::where('id', $fetch->bill_under)->decrement('total_bill_amount', $fetch->total_product_amount);
        $bill = Bill::where('id', $fetch->bill_under)->first();
        $fetch->delete();
        $subBills = Bill::where('bill_under', $bill->id)->get();
        $products = Product::get();
        $vendors = Vendor::get();

        return view('pages.Bills.updateBillPurchase', compact('bill', 'subBills', 'id', 'products', 'vendors'));
    }

    public function deleteSubBillSales($id)
    {
        $fetch = Bill::where('id', $id)->first();
        Product::where('id', $fetch->product_id)->increment('current_stock', $fetch->stock);
        Bill::where('id', $fetch->bill_under)->decrement('total_bill_amount', $fetch->total_product_amount);
        $bill = Bill::where('id', $fetch->bill_under)->first();
        $fetch->delete();
        $subBills = Bill::where('bill_under', $bill->id)->get();
        $products = Product::get();
        $customers = Customer::get();

        return view('pages.Bills.updateBillSales', compact('bill', 'subBills', 'id', 'products', 'customers'));
    }
}
