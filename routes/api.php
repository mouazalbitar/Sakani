<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::put('/user/update', [UserController::class, 'updateProfile'])
    ->middleware('auth:sanctum');

Route::prefix('/apartment')->group(function () {
    Route::get('/getAll', [ApartmentController::class, 'index'])
        ->middleware('auth:sanctum');
    Route::post('/add', [ApartmentController::class, 'store'])
        ->middleware('auth:sanctum');
})->middleware('auth:sanctum');


Route::prefix('/reviwe')->group(function () {
    Route::post('/add', [ReviewController::class, 'store'])
        ->middleware('auth:sanctum');
})->middleware('auth:sanctum');