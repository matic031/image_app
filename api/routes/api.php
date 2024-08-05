<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

Route::get('/images', [ImageController::class, 'getAllImages']);
Route::post('/images', [ImageController::class, 'createImage']);
Route::put('/images/{id}', [ImageController::class, 'updateImage']);
Route::delete('/images/{id}', [ImageController::class, 'deleteImage']);
