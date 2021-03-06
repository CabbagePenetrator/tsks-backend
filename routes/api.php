<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CompletedTaskController;
use App\Http\Controllers\CollectionTasksController;

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

Route::get('/collections', [CollectionController::class, 'index'])
    ->name('collections');

Route::post('/collections', [CollectionController::class, 'store'])
    ->name('collections.store');

Route::get('/collections/{collection}', [CollectionController::class, 'show'])
    ->name('collections.show');

Route::put('/collections/{collection}', [CollectionController::class, 'update'])
    ->name('collections.update');

Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])
    ->name('collections.destroy');

Route::get('/collections/{collection}/tasks', [CollectionTasksController::class, 'index'])
    ->name('collections.tasks');

Route::post('/collections/{collection}/tasks', [CollectionTasksController::class, 'store'])
    ->name('collections.tasks.store');

Route::get('/collections/{collection}/tasks/{task}', [CollectionTasksController::class, 'show'])
    ->name('collections.tasks.show');

Route::put('/collections/{collection}/tasks/{task}', [CollectionTasksController::class, 'update'])
    ->name('collections.tasks.update');

Route::delete('/collections/{collection}/tasks/{task}', [CollectionTasksController::class, 'destroy'])
    ->name('collections.tasks.destroy');

Route::put('/tasks/{task}/complete', [CompletedTaskController::class, 'update'])
    ->name('tasks.complete');

Route::delete('/tasks/{task}/uncomplete', [CompletedTaskController::class, 'destroy'])
    ->name('tasks.uncomplete');
