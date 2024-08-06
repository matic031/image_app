<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('images', ImageController::class);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('images/{image}/share', [ImageController::class, 'shareImage']);
    Route::get('users', [UserController::class, 'getAllUsers']);
});
