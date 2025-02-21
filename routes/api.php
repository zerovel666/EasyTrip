<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register',[AuthController::class, 'register']);
Route::post('/user/login',[AuthController::class, 'auth']);
Route::post('/password/refresh', [AuthController::class, 'refresh']);
Route::put('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::prefix('admin')->middleware(RoleMiddleware::class.':admin')->group(function (){
    Route::post('/country',[CountryController::class,'store']);
});