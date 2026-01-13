<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Notifications\TestFcmNotification;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/test_whatsapp', function (WhatsAppService $whatsapp) {
    $to = '963965050015';
    $message = 'i wish you are a dead body';
    $res = $whatsapp->sendMessage($to, $message);
    return response()->json($res);
});
Route::get('/test-notification', function () {
    $user = Auth::user(); // المستخدم الحالي
    $user->notify(new TestFcmNotification(
        'Hello!', 
        'This is a test FCM notification.'
    ));

    return 'Notification sent!';
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('/fcm-token', [FcmTokenController::class, 'store']);

Route::middleware('auth:sanctum')->get('/test-fcm', [TestNotificationController::class, 'sendTest']);

Route::get('/app/login', [UserController::class, 'store']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/verify', [UserController::class, 'verifyWhatsapp']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/loginAdmin', [UserController::class, 'loginAdmin']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/gov/getAll', [GovernorateController::class, 'index']);
Route::middleware('auth:sanctum')
    ->controller(GovernorateController::class)
    ->prefix('/gov')
    ->group(function () {
        Route::post('/addGovernorate', 'store')->middleware('isAdmin');
        Route::put('/editGovernorate/{id}', 'update')->middleware('isAdmin'); // match(['put', 'patch'],
    });

Route::get('/city/getCities/{id}', [CityController::class, 'showCities']);
Route::middleware('auth:sanctum')
    ->controller(CityController::class)
    ->prefix('/city')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::post('/addCity', 'store')->middleware('isAdmin');
        // Route::put('/editGovernorate/{id}', 'update')->middleware('isAdmin');
    });

Route::middleware('auth:sanctum')
    ->controller(UserController::class)
    ->prefix('/user')
    ->group(function () {
        Route::middleware('isAdmin')->group(function () {
            Route::get('/getAll', 'index');
            Route::get('/get_user/{id}', 'showUser');
            Route::get('/acceptedList', 'acceptedUsers');
            Route::get('/rejectedList', 'rejectedUsers');
            Route::get('/waitingList', 'waitingList');
            Route::put('/accept/{id}', 'acceptUser');
            Route::put('/reject/{id}', 'rejectUser');
        });
        Route::put('/update', 'updateProfile');
    });

Route::middleware('auth:sanctum')
    ->controller(ApartmentController::class)
    ->prefix('/apartment')
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::get('/avaliable_apartments', 'avaliable_apartment');
        Route::get('/owner_apartments', 'owner_apartment');
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
        Route::get('/get_booking', 'showBookings'); // for tenant
        Route::get('/owner/get_booking', 'showApartmentsBookings'); // for owner
        Route::get('/get_apartment_bookings/{apartment}', 'apartmentBookings'); // for one apartment
        Route::post('/add_booking', 'addBooking');
        Route::put('/update/{booking}', 'updateBooking'); // اسم المعامل يجب أن يطابق اسم المتغير في الدالة
        Route::put('/canceled_booking/{booking}', 'cancelBooking'); // for tenant
        Route::put('/accept/{booking}', 'acceptBooking'); // for owner
        Route::put('/reject/{booking}', 'rejectBooking'); // for owner
    });

Route::middleware('auth:sanctum')
    ->controller(ReviewController::class)
    ->prefix('/review')
    ->group(function () {
        Route::post('/add', 'store');
        Route::get('/apartment_reviews/{apartment}', 'apartmentReview');
    });

Route::middleware('auth:sanctum')
    ->prefix('/favorite')
    ->controller(FavoriteController::class)
    ->group(function () {
        Route::get('/getAll', 'index')->middleware('isAdmin');
        Route::get('/user_favorites', 'userFavorites');
        Route::post('/add', 'store');
        Route::delete('/remove/{favorite}', 'destroy');
    });
