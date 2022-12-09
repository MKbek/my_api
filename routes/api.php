<?php

use Illuminate\Http\Request;
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

Route::post('/auth', [\App\Http\Controllers\UserController::class, 'auth']);
Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);

Route::get('/animals', [\App\Http\Controllers\AnimalController::class, 'index']);
Route::get('/animal/{id}', [\App\Http\Controllers\AnimalController::class, 'getAnimal']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route for animal methods
    Route::post('/animal', [\App\Http\Controllers\AnimalController::class, 'create']);
    Route::put('/animal/{id}', [\App\Http\Controllers\AnimalController::class, 'update']);
    Route::delete('/animal/{id}', [\App\Http\Controllers\AnimalController::class, 'delete']);

    // Route for user logout
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
});
