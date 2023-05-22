<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Mockery\Generator\Method;
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

$pages = [
    [
        'name' => 'Product',
        'route' => [
            [
                'name' => 'gallery',
                'method' => 'get',
                'params' => 'product'
            ]
        ]
    ],
    [
        'name' => 'Product Gallery',
    ],
    [
        'name' => 'Transaction',
    ],
];

foreach ($pages as $page) {
    $controller = 'App\\Http\\Controllers\\' . str_replace(" ", "", $page['name']) . 'Controller';
    $uri = str_replace("y", "ie", Str::slug($page['name'], "-") . "s");
    Route::resource($uri, $controller);
    if (isset($page['route'])) {
        foreach ($page['route'] as $route_extra) {
            switch ($route_extra['method']) {
                case 'get':
                    Route::get(
                        isset($route_extra['params']) ?
                            $uri . '/' . $route_extra['name'] . '/{' . $route_extra['params'] . '}'
                            : $uri . '/' . $route_extra['name'],
                        $controller . '@' . $route_extra['name']
                    )->name($uri . '.' . $route_extra['name']);
                    break;
                case 'post':
                    // Kode yang akan dijalankan jika $route_extra['method'] sama dengan 'post'
                    // ...
                    break;
                case 'put':
                    // Kode yang akan dijalankan jika $route_extra['method'] sama dengan 'put'
                    // ...
                    break;
                case 'delete':
                    // Kode yang akan dijalankan jika $route_extra['method'] sama dengan 'delete'
                    // ...
                    break;
            }
        }
    }
}
