<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GovernorateController;
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
    ->controller(GovernorateController::class)
    ->prefix('/gov')
    ->group(function () {
        Route::get('/getAll', 'index');
        Route::post('/addGovernorate', 'store')->middleware('isAdmin');
        Route::put('/editGovernorate/{id}', 'update')->middleware('isAdmin');
    });


Route::middleware('auth:sanctum')
    ->controller(CityController::class)
    ->prefix('/city')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::get('/getCities/{id}', 'showCities');
        Route::post('/addCity', 'store')->middleware('isAdmin');
        Route::put('/editGovernorate/{id}', 'update')->middleware('isAdmin');
    });

Route::middleware('auth:sanctum')
    ->controller(UserController::class)
    ->prefix('/user')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::get('/acceptedList', 'acceptedUsers')->middleware('isAdmin');
        Route::get('/rejectedList', 'rejectedUsers')->middleware('isAdmin');
        Route::get('/waitingList', 'waitingList')->middleware('isAdmin');
        Route::put('/accept/{id}', 'acceptUser')->middleware('isAdmin');
        Route::put('/reject/{id}', 'rejectUser')->middleware('isAdmin');
        Route::put('/update', 'updateProfile');
    });

Route::middleware('auth:sanctum')
    ->controller(ApartmentController::class)
    ->prefix('/apartment')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::get('/avaliable_apartments', 'avaliable_apartment');
        Route::get('/waiting_apartments', 'waitingList')->middleware('isAdmin');
        Route::get('/rejected_apartments', 'rejectedList')->middleware('isAdmin');
        Route::put('/accept/{id}', 'accept_apartment')->middleware('isAdmin');
        Route::put('/reject/{id}', 'reject_apartment')->middleware('isAdmin');
        Route::post('/add_apartment', 'add_apartment');
        Route::prefix('/filter')->group(function () {
            Route::get('/governorate/{govId}', 'gov_filter');
            Route::get('/city/{cityId}', 'city_filter');
            Route::get('/condition/{conditionId}', 'condition_filter');
            Route::get('/size/{start}-{end}', 'size_filter');
            Route::get('/price/{start}-{end}', 'price_filter');
        });
    });

Route::middleware('auth:sanctum')
    ->controller(BookingController::class)
    ->prefix('/booking')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::post('/add_booking', 'addBooking');
    });


Route::middleware('auth:sanctum')->prefix('/reviwe')->group(function () {
    Route::post('/add', [ReviewController::class, 'store']);
});


