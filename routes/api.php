<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'register']);
Route::post('/verify', [UserController::class, 'verifyWhatsapp']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    Route::get('/getAll', [UserController::class, 'index'])->middleware('isAdmin');
    Route::put('/update', [UserController::class, 'updateProfile']);
});


Route::middleware('auth:sanctum')->prefix('/apartment')->group(function () {
    Route::get('/getAll', [ApartmentController::class, 'index']);
    Route::post('/add', [ApartmentController::class, 'store']);
});


Route::middleware('auth:sanctum')->prefix('/reviwe')->group(function () {
    Route::post('/add', [ReviewController::class, 'store']);
});