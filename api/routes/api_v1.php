<?php

use Illuminate\Support\Facades\Route;

/** Controllers */
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CartProductController;

Route::apiResource('product', ProductController::class);
Route::apiResource('cart', CartController::class);
Route::apiResource('cart.product', CartProductController::class);
