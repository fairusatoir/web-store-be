<?php

use App\Helpers\RouteHelper;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductGalleryController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


// @phpstan-ignore-next-line
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)
        ->except(['show']);

    Route::get('products/{product}/galleries', [ProductController::class, 'gallery'])
        ->name('products.galleries');

    Route::resource('product-galleries', ProductGalleryController::class)
        ->except(['show', 'edit', 'update']);

    Route::resource('transactions', TransactionController::class)
        ->except(['create', 'store']);

    Route::get('transactions/{transaction}/set-status', [TransactionController::class, 'setStatus'])
        ->name('transactions.set-status');
});
