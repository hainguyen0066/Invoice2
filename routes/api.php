<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/getAllInvoice', [InvoiceController::class, 'getAllInvoices']);
Route::get('/serachInvoice', [InvoiceController::class, 'searchInvoice']);
Route::get('/createInvoice', [InvoiceController::class, 'createInvoice']);
Route::get('/getAllcustomers', [CustomerController::class, 'getAllCustomer']);
Route::get('/getAllProducts', [ProductController::class, 'getAllProduct']);
Route::post('/addInvoice', [InvoiceController::class, 'addInvoice']);
