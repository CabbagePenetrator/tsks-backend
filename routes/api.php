<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/collections', [CollectionController::class, 'store'])
    ->name('collections.store');

Route::get('/collections/{collection}', [CollectionController::class, 'show'])
    ->name('collections.show');

Route::put('/collections/{collection}', [CollectionController::class, 'update'])
    ->name('collections.update');

Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])
    ->name('collections.destroy');
