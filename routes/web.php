<?php

use App\Helpers\RouteHelper;
use Mockery\Generator\Method;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// @phpstan-ignore-next-line
Auth::routes(['register' => false]);

$pages = [
    [
        'name' => 'Product',
        'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
        'nested' => [
            [
                'name' => 'gallery',
                'method' => 'get',
                'params' => 'product'
            ]
        ]
    ],
    [
        'name' => 'Product Gallery',
        'only' => ['index', 'create', 'store', 'destroy'],
    ],
    [
        'name' => 'Transaction',
        'only' => ['index', 'show', 'edit', 'update', 'destroy'],
        'nested' => [
            [
                'name' => 'set status',
                'method' => 'get',
                'params' => 'transaction'
            ]
        ]
    ],
];

foreach ($pages as $page) {

    $route = new RouteHelper($page);

    Route::resource(
        $route->getUri(),
        $route->getController()
    )->only($page['only'] ?? null)->middleware('auth');

    if ($route->nestedExist()) {
        foreach ($route->getSubroute() as $subroute) {
            switch ($subroute['method']) {
                case 'get':
                    Route::get(
                        $route->getSubRouteUri($subroute),
                        $route->getSubController($subroute)
                    )->name($route->getNameSubroute($subroute))->middleware('auth');
                    break;
                case 'post':
                    // Kode yang akan dijalankan jika $subroute['method'] sama dengan 'post'
                    // ...
                    break;
                case 'put':
                    // Kode yang akan dijalankan jika $subroute['method'] sama dengan 'put'
                    // ...
                    break;
                case 'delete':
                    // Kode yang akan dijalankan jika $subroute['method'] sama dengan 'delete'
                    // ...
                    break;
                default:
                    break;
            }
        }
    }
}
