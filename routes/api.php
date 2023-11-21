<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-all-invoices', [InvoiceController::class, 'getAllInvoices']);
Route::get('/search_invoice',[InvoiceController::class,'searchInvoice']);
Route::get('/create_invoice',[InvoiceController::class,'createInvoice']);
Route::post('/add_invoice', [InvoiceController::class, 'addInvoice']);
Route::get('/show_invoice/{id}', [InvoiceController::class, 'getInvoice']);
Route::get('/edit_invoice/{id}', [InvoiceController::class, 'getEditInvoice']);
Route::get('/delete_invoice_items/{id}', [InvoiceController::class, 'deleteInvoiceItems']);
Route::post('/update_invoice/{id}', [InvoiceController::class, 'updateInvoice']);
Route::get('/delete_invoice/{id}', [InvoiceController::class, 'deleteInvoice']);

Route::get('/customers', [CustomerController::class, 'getAllCustomers']);

Route::get('/products', [ProductController::class, 'getAllProducts']);