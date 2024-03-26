<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ReturnedProduct;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request)
    {
        $productName = $request->searchProduct;
        $products = Product::where('name', 'like', '%' . $productName . '%')
            ->with(['brand' => fn($q) => $q->select(['id', 'name'])])
            ->with(['unit' => fn($q) => $q->select(['id', 'name'])])
            ->paginate(6);

        return view('pages.products', compact('products'));
    }

    public function searchCategory(Request $request)
    {
        $categoryName = $request->searchCategory;
        $categories = Category::where('name', 'like', '%' . $categoryName . '%')->paginate(6);

        return view('pages.categories', compact('categories'));

    }

    public function searchUnit(Request $request)
    {
        $unitName = $request->searchUnit;
        $units = Unit::where('name', 'like', '%' . $unitName . '%')->paginate(6);

        return view('pages.units', compact('units'));
    }

    public function searchBrand(Request $request)
    {
        $brandName = $request->searchBrand;
        $brands = Brand::where('name', 'like', '%' . $brandName . '%')->paginate(6);

        return view('pages.brand', compact('brands'));
    }

    public function searchVendor(Request $request)
    {
        $vendorName = $request->searchVendor;
        $vendors = Vendor::where('name', 'like', '%' . $vendorName . '%')->paginate(6);

        return view('pages.vendors', compact('vendors'));
    }

    public function searchCustomer(Request $request)
    {
        $customerName = $request->searchCustomer;
        $customers = Customer::where('name', 'like', '%' . $customerName . '%')->paginate(6);

        return view('pages.customer', compact('customers'));
    }

    public function searchReturn(Request $request)
    {
        $returnName = $request->searchReturn;
        $returns = ReturnedProduct::with(['returnable', 'product'])
            ->where('bill_under', null)
            ->where(function ($query) use ($returnName) {
                $query->where('bill_no', 'like', "%$returnName%")
                    ->orWhereHasMorph('returnable', [Customer::class], function ($query) use ($returnName) {
                        $query->where('name', 'LIKE', "%$returnName%");
                    })
                    ->orWhereHasMorph('returnable', [Vendor::class], function ($query) use ($returnName) {
                        $query->where('name', 'LIKE', "%$returnName%");
                    });
            })
            ->paginate(10);

        return view('pages.returned', compact('returns'));
    }

    public function searchBill(Request $request)
    {

        $searchTerm = $request->searchBill;


        $bills = Bill::with(['billable', 'product'])
            ->where('bill_under', null)
            ->where(function ($query) use ($searchTerm) {
                $query->where('bill_no', 'like', "%$searchTerm%")
                    ->orWhereHasMorph('billable', [Customer::class], function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%$searchTerm%");
                    })
                    ->orWhereHasMorph('billable', [Vendor::class], function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%$searchTerm%");
                    });
            })
            ->paginate(10);
        return view('pages.bill', compact('bills'));

    }


}

