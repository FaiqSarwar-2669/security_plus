<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RegisterationController, loginController};

Route::post('/registeration', [RegisterationController::class, 'store']);
Route::post('/login', [loginController::class, 'store']);
Route::post('/forgetPassword', [loginController::class, 'passwordReset']);

Route::get('/organizations', [RegisterationController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [loginController::class, 'logout']);

    // Routes for Service Provider Companies
    Route::middleware(['checkUserRole:Service Provider'])->group(function () {
    });

    // Routes for Service Takers Client
    Route::middleware(['checkUserRole:Service Taker'])->group(function () {
    });

    // Routes for Admin
    Route::middleware(['checkUserRole:Admin'])->group(function () {
    });

    // Routes for Guards
    Route::middleware(['checkUserRole:Guards'])->group(function () {
    });

});
