<?php

use \App\Http\Controllers\TimerController;
use \App\Http\Controllers\ToyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/brinquedo', [ToyController::class, 'createToy']);
    Route::put('/update/brinquedo/{id}', [ToyController::class, 'updateToy']);
    Route::delete('/brinquedo/{id}', [ToyController::class, 'removeToy']);
    Route::get('/brinquedo', [ToyController::class, 'getToys']);
    Route::post('/timer', [TimerController::class, 'createTimer']);
    Route::get('/timer/{data_interval_min?}/{data_interval_max?}', [TimerController::class, 'getTimers']);
    Route::delete('/timer/{id}', [TimerController::class, 'removeTimer']);
});
