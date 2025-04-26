<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\UsersController;


    Route::resource('/sales', SalesController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/expenses', ExpensesController::class);
    Route::resource('/goals', GoalsController::class);
    Route::resource('/users', UsersController::class);
