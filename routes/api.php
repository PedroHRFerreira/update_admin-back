<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;

Route::resource('products', ProductsController::class);
Route::resource('sales', SalesController::class);
