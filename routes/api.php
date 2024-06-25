<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RegisterationController, GuardController, ReviewController, Organizations, loginController, formAndPortfolioController, ChatController};

Route::post('/registeration', [RegisterationController::class, 'store']);
Route::post('/login', [loginController::class, 'store']);
Route::post('/forgetPassword', [loginController::class, 'passwordReset']);

Route::get('/All-Portfolios', [Organizations::class, 'getAllPortfolios']);
Route::get('/get-form/{id}', [Organizations::class, 'getSpecificForm']);
Route::post('/jobAppication', [Organizations::class, 'uploadApplications']);

Route::get('/viewApplications/{id}', [Organizations::class, 'viewJobApplication']);
Route::get('/get-reviews/{id}', [ReviewController::class, 'getReviews']);


Route::middleware('auth:sanctum')->group(function () {


    Route::post('/chat', [ChatController::class, 'store']);

    Route::get('/logout', [loginController::class, 'logout']);

    // Routes for Service Provider Companies
    Route::middleware(['checkUserRole:Provider'])->group(function () {

        Route::post('/makePortfolio', [formAndPortfolioController::class, 'storePortfolio']);
        Route::get('/getPortfolio', [formAndPortfolioController::class, 'getPortfolio']);
        Route::post('/makeForm', [formAndPortfolioController::class, 'storeForm']);
        Route::get('/getForm', [formAndPortfolioController::class, 'getForm']);
        Route::get('/getApplications', [Organizations::class, 'getJobApplications']);
        Route::post('/activejobApplication', [Organizations::class, 'ActiveJobApplications']);
        Route::post('/rejectjobApplication', [Organizations::class, 'RejectedJobApplications']);
        Route::get('/get-provider', [RegisterationController::class, 'edit']);
        Route::post('/update-provider', [RegisterationController::class, 'update']);
        Route::post('/registerGuard', [GuardController::class, 'store']);
        // Route::get('/viewApplications/{id}', [Organizations::class, 'viewJobApplication']);
        
    });

    // Routes for Service Takers Client
    Route::middleware(['checkUserRole:Taker'])->group(function () {
        Route::get('/get-Portfolios', [Organizations::class, 'getAllPortfolios']);
        Route::get('/get-sidebar', [Organizations::class, 'getClientSidebar']);
        Route::get('/get-client', [RegisterationController::class, 'edit']);
        Route::post('/update-client', [RegisterationController::class, 'update']);
        Route::post('/submit-review', [ReviewController::class, 'AddReview']);
        Route::get('/get-review/{id}', [ReviewController::class, 'getReviews']);
    });

    // Routes for Admin
    Route::middleware(['checkUserRole:Admin'])->group(function () {

        Route::post('/newPassword', [RegisterationController::class, 'newPassword']);

        //for all organizations and companies
        Route::post('/remindRegisteration', [RegisterationController::class, 'reminderOrganizationRegisteration']);
        Route::get('/viewOganization/{id}', [RegisterationController::class, 'getOrganization']);

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
