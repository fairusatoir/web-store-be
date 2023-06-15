<?php

use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
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

Route::middleware([''])->group(function () {

    Route::resource('products', ProductController::class)
        ->only(['index', 'show']);

    Route::resource('checkouts', CheckoutController::class)
        ->only(['store']);

    Route::resource('transactions', TransactionController::class)
        ->only(['index', 'show']);
});
