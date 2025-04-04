<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;


    Route::resource('/sales', SalesController::class);
    Route::resource('/products', ProductsController::class);
