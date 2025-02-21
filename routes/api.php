<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register',[AuthController::class, 'register']);
Route::post('/user/login',[AuthController::class, 'auth']);
Route::post('/password/refresh', [AuthController::class, 'refresh']);
Route::put('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::prefix('admin')->middleware(RoleMiddleware::class.':admin')->group(function (){
    Route::post('/country',[CountryController::class,'store']);
    Route::put('/country/{name_recreation}',[CountryController::class, 'update']);
});

Route::get('/country/all',[CountryController::class, 'all']);
Route::get('/country/{name_recreation}',[CountryController::class, 'show']);


Route::prefix('payment')->middleware(RoleMiddleware::class.':standart')->group(function (){
    Route::post('/getUrl/{name_recreation}',[PaymentController::class,'getUrl']);
    Route::post('/paid/{num_pay}', [PaymentController::class, 'paid'])->name('payment.paid');
});