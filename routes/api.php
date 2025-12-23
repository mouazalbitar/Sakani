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
Route::post('/loginAdmin', [UserController::class, 'loginAdmin']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')
    ->controller(UserController::class)
    ->prefix('/user')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::put('/accept/{id}', [UserController::class, 'acceptUser'])->middleware('isAdmin');
        Route::put('/reject/{id}', [UserController::class, 'rejectUser'])->middleware('isAdmin');
        Route::put('/update', [UserController::class, 'updateProfile']);
    });


Route::middleware('auth:sanctum')
    ->controller(ApartmentController::class)
    ->prefix('/apartment')
    ->group(function () {
        Route::get('/getAll', 'index');
        Route::post('/add', 'store');
    });


Route::middleware('auth:sanctum')->prefix('/reviwe')->group(function () {
    Route::post('/add', [ReviewController::class, 'store']);
});