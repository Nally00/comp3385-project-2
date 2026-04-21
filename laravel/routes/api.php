<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
    });

    Route::get('services', [ServiceController::class, 'index']);
    Route::get('services/{service_id}', [ServiceController::class, 'show']);
    Route::get('search', [ServiceController::class, 'search']);
    Route::get('users/{user_id}', [UserController::class, 'show']);
    Route::get('users/{user_id}/favourites', [UserController::class, 'favourites']);

    Route::middleware('auth:api')->group(function () {
        Route::post('services', [ServiceController::class, 'store']);
        Route::post('services/{service_id}/favourite', [FavouriteController::class, 'store']);
    });
});