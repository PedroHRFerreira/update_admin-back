<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;

Route::middleware('api')->group(function () {
    Route::resource('/sales', SalesController::class);
});
