<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// @phpstan-ignore-next-line
Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

$pages = ['Product', 'Product Gallery'];

foreach ($pages as $page) {
    $controller = 'App\\Http\\Controllers\\' . str_replace(" ", "", $page) . 'Controller';
    $uri = str_replace("y", "ie", Str::slug($page, "-") . "s");
    Route::resource($uri, $controller);
}
