<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/images', [ImageController::class, 'getAllImages'])->middleware('auth:api');
Route::post('/images', [ImageController::class, 'createImage'])->middleware('auth:api');
Route::put('/images/{id}', [ImageController::class, 'updateImage'])->middleware('auth:api');
Route::delete('/images/{id}', [ImageController::class, 'deleteImage'])->middleware('auth:api');

Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


// Route::middleware('auth:api')->group(function () {
//     Route::get('/images', [ImageController::class, 'getAllImages']);
//     Route::post('/images', [ImageController::class, 'createImage']);
//     Route::put('/images/{id}', [ImageController::class, 'updateImage']);
//     Route::delete('/images/{id}', [ImageController::class, 'deleteImage']);

//     Route::get('user', [AuthController::class, 'user']);
//     Route::post('logout', [AuthController::class, 'logout']);
// });
