<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RegisterationController, loginController, formAndPortfolioController};

Route::post('/registeration', [RegisterationController::class, 'store']);
Route::post('/login', [loginController::class, 'store']);
Route::post('/forgetPassword', [loginController::class, 'passwordReset']);




Route::middleware('auth:sanctum')->group(function () {


    Route::post('/makePortfolio',[formAndPortfolioController::class,'storePortfolio']);
    Route::get('/getPortfolio',[formAndPortfolioController::class,'getPortfolio']);
    Route::post('/makeForm',[formAndPortfolioController::class,'storeForm']);
    Route::get('/getForm',[formAndPortfolioController::class,'getForm']);


    Route::get('/logout', [loginController::class, 'logout']);

    // Routes for Service Provider Companies
    Route::middleware(['checkUserRole:Service Provider'])->group(function () {
    });

    // Routes for Service Takers Client
    Route::middleware(['checkUserRole:Service Taker'])->group(function () {
    });

    // Routes for Admin
    Route::middleware(['checkUserRole:Admin'])->group(function () {

        Route::post('/newPassword',[RegisterationController::class, 'newPassword']);
        //for register companies and organizations
        Route::get('/registerCompanies', [RegisterationController::class, 'index']);
        Route::get('/registerClientOrganization', [RegisterationController::class, 'registerClientOrganization']);

        //for unregister companies and organizations
        Route::get('/unRegisterCompanies', [RegisterationController::class, 'inActiveCompanies']);
        Route::get('/unRegisterClient', [RegisterationController::class, 'unRegisterClientOrganization']);

        //for activation and inactivation
        Route::post('/activation', [RegisterationController::class, 'inActiveOrganizationsMethod']);

        Route::post('/inActivation', [RegisterationController::class, 'activeOrganizationsMethod']);
    });

    // Routes for Guards
    Route::middleware(['checkUserRole:Guards'])->group(function () {
    });
});
