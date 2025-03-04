<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\ProductAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthAPIController::class, 'login']);
    Route::post('register', [AuthAPIController::class, 'register']);

    Route::get('/products', [ProductAPIController::class, 'getAll']);
    Route::get('/products/{id}', [ProductAPIController::class, 'getById']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserAPIController::class, 'show']);
        Route::put('/user/{id}', [UserAPIController::class, 'update']);
        Route::post('/logout', [AuthAPIController::class, 'logout']);

        Route::put('/products/{id}', [ProductAPIController::class, 'update']);
    });
});
