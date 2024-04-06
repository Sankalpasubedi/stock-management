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
use App\Services\BillService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\ReturnedService;
use App\Services\UnitService;
use App\Services\VendorService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.index');
    }

    public function category(CategoryService $categoryService)
    {
        $categories = $categoryService->getCategory();
        return view('pages.categories', compact('categories'));
    }

    public function brand(BrandService $brandService)
    {
        $brands = $brandService->getBrand();
        return view('pages.brand', compact('brands'));
    }

    public function unit(UnitService $unitService)
    {
        $units = $unitService->getUnit();
        return view('pages.units', compact('units'));
    }

    public function vendor(VendorService $vendorService)
    {
        $vendors = $vendorService->getVendor();
        return view('pages.vendors', compact('vendors'));
    }

    public function customer(CustomerService $customerService)
    {
        $customers = $customerService->getCustomer();
        return view('pages.customer', compact('customers'));
    }

    public function product(ProductService $productService)
    {
        $products = $productService->getProduct();
        return view('pages.products', compact('products'));
    }

    public function return(ReturnedService $returnedService)
    {
        $returns = $returnedService->getReturnedProducts();
        return view('pages.returned', compact('returns'));
    }

    public function bill(BillService $billService)
    {
        $bills = $billService->getBills();
        return view('pages.bill', compact('bills'));
    }
}
