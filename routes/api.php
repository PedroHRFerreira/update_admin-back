<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::resource('products', ProductsController::class);
