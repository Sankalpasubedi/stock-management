<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReturnedProductController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'bill'])->name('home');

Route::get('/category', [PageController::class, 'category'])->name('category');
Route::get('/addCategory', [CategoryController::class, 'addCategory'])->name('addCategory');
Route::post('createCategory', [CategoryController::class, 'create'])->name('createCategory');
Route::get('/updateCategory/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
Route::patch('saveCategory/{id}', [CategoryController::class, 'update'])->name('saveCategory');
Route::delete('deleteCategory/{id}', [CategoryController::class, 'delete'])->name('deleteCategory');


Route::get('/product', [PageController::class, 'product'])->name('product');
Route::get('/addProduct', [ProductController::class, 'addProduct'])->name('addProduct');
Route::post('createProduct', [ProductController::class, 'create'])->name('createProduct');
Route::get('/updateProduct/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
Route::patch('saveProduct/{id}', [ProductController::class, 'update'])->name('saveProduct');
Route::delete('deleteProduct/{id}', [ProductController::class, 'delete'])->name('deleteProduct');


Route::get('/unit', [PageController::class, 'unit'])->name('unit');
Route::get('/addUnit', [UnitController::class, 'addUnit'])->name('addUnit');
Route::post('createUnit', [UnitController::class, 'create'])->name('createUnit');
Route::get('/updateUnit/{id}', [UnitController::class, 'updateUnit'])->name('updateUnit');
Route::patch('saveUnit/{id}', [UnitController::class, 'update'])->name('saveUnit');
Route::delete('deleteUnit/{id}', [UnitController::class, 'delete'])->name('deleteUnit');


Route::get('/brand', [PageController::class, 'brand'])->name('brand');
Route::get('/addBrand', [BrandController::class, 'addBrand'])->name('addBrand');
Route::post('createBrand', [BrandController::class, 'create'])->name('createBrand');
Route::get('/updateBrand/{id}', [BrandController::class, 'updateBrand'])->name('updateBrand');
Route::patch('saveBrand/{id}', [BrandController::class, 'update'])->name('saveBrand');
Route::delete('deleteBrand/{id}', [BrandController::class, 'delete'])->name('deleteBrand');


Route::get('/vendor', [PageController::class, 'vendor'])->name('vendor');
Route::get('/addVendor', [VendorController::class, 'addVendor'])->name('addVendor');
Route::post('createVendor', [VendorController::class, 'create'])->name('createVendor');
Route::get('/updateVendor/{id}', [VendorController::class, 'updateVendor'])->name('updateVendor');
Route::patch('saveVendor/{id}', [VendorController::class, 'update'])->name('saveVendor');
Route::delete('deleteVendor/{id}', [VendorController::class, 'delete'])->name('deleteVendor');


Route::get('/customer', [PageController::class, 'customer'])->name('customer');
Route::get('/addCustomer', [CustomerController::class, 'addCustomer'])->name('addCustomer');
Route::post('createCustomer', [CustomerController::class, 'create'])->name('createCustomer');
Route::get('/updateCustomer/{id}', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
Route::patch('saveCustomer/{id}', [CustomerController::class, 'update'])->name('saveCustomer');
Route::delete('deleteCustomer/{id}', [CustomerController::class, 'delete'])->name('deleteCustomer');


Route::get('/bill', [PageController::class, 'bill'])->name('bill');
Route::get('/addPurchase', [BillController::class, 'addPurchase'])->name('addPurchase');
Route::get('/addSales', [BillController::class, 'addSales'])->name('addSales');
Route::post('createPurchase', [BillController::class, 'createPurchase'])->name('createPurchase');
Route::get('/updateBillPurchase/{id}', [BillController::class, 'updateBillPurchase'])->name('updateBillPurchase');
Route::get('/updatePurchase/{id}/{stock}/{price}', [BillController::class, 'updatePurchase'])->name('updatePurchase');
Route::patch('savePurchase/{id},{stock}', [BillController::class, 'savePurchase'])->name('savePurchase');
Route::patch('saveBillPurchase/{id}', [BillController::class, 'saveBillPurchase'])->name('saveBillPurchase');
Route::post('createSales', [BillController::class, 'createSales'])->name('createSales');
Route::get('/updateBillSales/{id}', [BillController::class, 'updateBillSales'])->name('updateBillSales');
Route::get('/updateSales/{id}/{stock}/{price}', [BillController::class, 'updateSales'])->name('updateSales');
Route::patch('saveSales/{id},{stock}', [BillController::class, 'saveSales'])->name('saveSales');
Route::patch('saveBillSales/{id}', [BillController::class, 'saveBillSales'])->name('saveBillSales');
Route::delete('deleteBill/{id}', [BillController::class, 'delete'])->name('deleteBill');
Route::delete('deleteSubBill/{id}', [BillController::class, 'deleteSubBill'])->name('deleteSubBill');
Route::delete('deleteSubBillSales/{id}', [BillController::class, 'deleteSubBillSales'])->name('deleteSubBillSales');
Route::patch('paidBill/{id}', [BillController::class, 'paidBill'])->name('paidBill');

Route::delete('returnProduct/{id}', [BillController::class, 'returnProduct'])->name('returnProduct');
Route::get('previewBill/{id}', [BillController::class, 'previewBill'])->name('previewBill');

Route::get('/return', [PageController::class, 'return'])->name('return');
Route::patch('paidReturn/{id}', [ReturnedProductController::class, 'paidReturn'])->name('paidReturn');
Route::delete('deleteReturned/{id}', [ReturnedProductController::class, 'deleteReturned'])->name('deleteReturned');


Route::get('/searchProduct', [ProductController::class, 'searchProduct'])->name('searchProduct');
Route::get('/searchCategory', [CategoryController::class, 'searchCategory'])->name('searchCategory');
Route::get('/searchUnit', [UnitController::class, 'searchUnit'])->name('searchUnit');
Route::get('/searchBrand', [BrandController::class, 'searchBrand'])->name('searchBrand');
Route::get('/searchVendor', [VendorController::class, 'searchVendor'])->name('searchVendor');
Route::get('/searchCustomer', [CustomerController::class, 'searchCustomer'])->name('searchCustomer');
Route::get('/searchBill', [BillController::class, 'searchBill'])->name('searchBill');
Route::get('/searchReturn', [ReturnedProductController::class, 'searchReturn'])->name('searchReturn');
