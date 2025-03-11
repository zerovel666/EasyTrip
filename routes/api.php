<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LikeCountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/user/register',[AuthController::class, 'register']);
Route::post('/user/login',[AuthController::class, 'auth']);
Route::post('/password/refresh', [AuthController::class, 'refresh']);
Route::put('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware(RoleMiddleware::class.':standart')->group(function (){
    Route::post('/country/like', [LikeCountryController::class,'like']);
});

Route::get('/country/best',[CountryController::class,'getBests']);
Route::get('/country/countByname',[CountryController::class,'countByname']);
Route::get('/country/all',[CountryController::class, 'all']);
Route::get('/country/{trip_name}',[CountryController::class, 'show']);

Route::prefix('payment')->middleware(RoleMiddleware::class.':standart')->group(function (){
    Route::post('/paid', [PaymentController::class, 'paid']);
});

Route::prefix('booking')->middleware(RoleMiddleware::class.':standart')->group(function(){
    Route::post('/{trip_name}',[BookingController::class,'createBooking']);
    Route::delete('/{trip_name}',[BookingController::class,'cancelBooking']);
});

Route::get("/booking/{trip_name}",[BookingController::class, 'allByTripName']);

Route::prefix('admin')->middleware(RoleMiddleware::class.':admin')->group(function (){
    Route::get('/table',[AdminController::class,'getAllTableName']);
    Route::prefix('booking')->group(function (){
        Route::get('/column',[BookingController::class,'getColumn']);
        Route::delete('/{id}',[BookingController::class,'deleteById']);
        Route::post('update/{id}',[BookingController::class, 'updateById']);
        Route::get('/download',[BookingController::class,'downloadTableColumnOrThisRelation']);
        Route::post('/create',[BookingController::class,'createAdmin']);
    });
    Route::prefix('country')->group(function (){
        Route::get('/column',[CountryController::class,'getColumn']);
        Route::get('/data',[CountryController::class, 'data']);
        Route::delete('/{id}',[CountryController::class, 'deleteById']);
        Route::post('update/{id}',[CountryController::class, 'updateById']);
        Route::get('/download',[CountryController::class,'downloadTableColumnOrThisRelation']);
    });
    Route::prefix('user')->group(function (){
        Route::get('/all',[UserController::class, 'all']);
    });
});
// Route::prefix('admin')->middleware(RoleMiddleware::class.':admin')->group(function (){
//     Route::post('/country',[CountryController::class,'store']);
//     Route::put('/country/{trip_name}',[CountryController::class, 'update']);
//     Route::post('/description/country',[DescriptionCountryController::class,'store']);
// });