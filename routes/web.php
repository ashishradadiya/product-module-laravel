<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'listProduct'])->name('product.list');
Route::get('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'storeProduct'])->name('product.store');
Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
Route::put('/product/update', [ProductController::class, 'updateProduct'])->name('product.update');
