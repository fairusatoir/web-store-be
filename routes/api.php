<?php

use App\Helpers\RouteHelper;
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

$pages = [
    [
        'name' => 'Product',
    ]
];

foreach ($pages as $page) {

    $route = new RouteHelper($page);

    Route::resource(
        $route->getUri(),
        $route->getApiController()
    )->except(['create', 'store', 'edit']);;

    if ($route->subrouteExist()) {
        foreach ($route->getSubroute() as $subroute) {
            switch ($subroute['method']) {
                case 'get':
                    Route::get(
                        $route->getSubRouteUri($subroute),
                        $route->getSubController($subroute)
                    )->name($route->getNameSubroute($subroute));
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
