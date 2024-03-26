<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStocksHistory;
use App\Models\ReturnedProduct;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.index');
    }

    public function category()
    {
        $categories = Category::paginate(6);
        return view('pages.categories', compact('categories'));
    }

    public function brand()
    {
        $brands = Brand::paginate(6);
        return view('pages.brand', compact('brands'));
    }

    public function unit()
    {
        $units = Unit::paginate(6);
        return view('pages.units', compact('units'));
    }

    public function vendor()
    {
        $vendors = Vendor::paginate(6);
        return view('pages.vendors', compact('vendors'));
    }

    public function customer()
    {
        $customers = Customer::paginate(6);
        return view('pages.customer', compact('customers'));
    }

    public function product()
    {
        $products = Product::with(['category' => fn($q) => $q->select(['id', 'name'])])
            ->with(['brand' => fn($q) => $q->select(['id', 'name'])])
            ->with(['unit' => fn($q) => $q->select(['id', 'name'])])
            ->paginate(6);
        return view('pages.products', compact('products'));
    }

    public function return()
    {
        $returns = ReturnedProduct::with(['returnable', 'product'])->where('bill_under', null)
            ->paginate(6);
        return view('pages.returned', compact('returns'));
    }

    public function bill()
    {
        $bills = Bill::with(['billable', 'product'])->where('bill_under', null)
            ->paginate(6);
        return view('pages.bill', compact('bills'));
    }
}
