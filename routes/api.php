<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DescriptionCountryController;
use App\Http\Controllers\ImageCountryController;
use App\Http\Controllers\LikeCountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/user/register',[AuthController::class, 'register']);
Route::post('/user/login',[AuthController::class, 'auth']);
Route::post('/password/refresh', [AuthController::class, 'refresh']);
Route::put('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware(RoleMiddleware::class.':standart')->group(function (){
    Route::post('/country/like', [LikeCountryController::class,'like']);
    Route::get('/userInfo/{id}',[UserController::class, 'getUser']);
    Route::get('/userBooking/{id}',[BookingController::class, 'getByUserId']);
    Route::put('/userInfo/{id}',[UserController::class, 'updateById']);
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
        Route::post('/create',[CountryController::class,'createAdmin']);
    });
    Route::prefix('users')->group(function (){
        Route::get('/column',[UserController::class,'getColumn']);
        Route::get('/data',[UserController::class, 'data']);
        Route::delete('/{id}',[UserController::class, 'deleteById']);
        Route::post('update/{id}',[UserController::class, 'updateById']);
    });
    Route::prefix('descriptionCountry')->group(function (){
        Route::get('/column',[DescriptionCountryController::class,'getColumn']);
        Route::get('/data',[DescriptionCountryController::class, 'data']);
        Route::delete('/{id}',[DescriptionCountryController::class, 'deleteById']);
        Route::post('update/{id}',[DescriptionCountryController::class, 'updateBy']);
    });
    Route::prefix('imageCountry')->group(function (){
        Route::get('/column',[ImageCountryController::class,'getColumn']);
        Route::get('/data',[ImageCountryController::class, 'data']);
        Route::delete('/{id}',[ImageCountryController::class, 'deleteById']);
        Route::post('update/{id}',[ImageCountryController::class, 'updateBy']);
    });
    Route::prefix('tags')->group(function (){
        Route::get('/column',[TagsController::class,'getColumn']);
        Route::get('/data',[TagsController::class, 'data']);
        Route::delete('/{id}',[TagsController::class, 'deleteById']);
        Route::post('update/{id}',[TagsController::class, 'updateBy']);
        Route::get('/download',[TagsController::class,'downloadTableColumnOrThisRelation']);
        Route::post('/create',[TagsController::class, 'create']);
    });
});
