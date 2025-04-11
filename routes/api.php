<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ExpensesController;


    Route::resource('/sales', SalesController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/expenses', ExpensesController::class);
