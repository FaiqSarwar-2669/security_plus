<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RegisterationController, GuardController, ReviewController,
     Organizations, loginController, formAndPortfolioController, MessageController,
     DashboardController,AttendenceController
    };

Route::post('/registeration', [RegisterationController::class, 'store']);
Route::post('/login', [loginController::class, 'store']);
Route::post('/forgetPassword', [loginController::class, 'passwordReset']);

Route::get('/All-Portfolios', [Organizations::class, 'getAllPortfolios']);
Route::get('/get-form/{id}', [Organizations::class, 'getSpecificForm']);
Route::post('/jobAppication', [Organizations::class, 'uploadApplications']);
Route::post('ApplicationImage',[Organizations::class, 'uploadImage']);

Route::get('/respond', [GuardController::class, 'handleResponse']);


Route::get('/viewApplications/{id}', [Organizations::class, 'viewJobApplication']);
Route::get('/get-reviews/{id}', [ReviewController::class, 'getReviews']);



Route::middleware('auth:sanctum')->group(function () {

    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/chatmembers', [MessageController::class, 'index']);
    Route::get('/getmessages/{id}', [MessageController::class, 'getMessage']);

    Route::get('/logout', [loginController::class, 'logout']);

    // Routes for Service Provider Companies
    Route::middleware(['checkUserRole:Provider'])->group(function () {

        Route::get('/dashBoardData', [DashboardController::class, 'ServiceProvider']);
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
        Route::get('/viewApp/{id}', [Organizations::class, 'viewJob']);
        Route::get('/getAllGuards', [GuardController::class, 'getAllGuards']);
        Route::post('/getComapanyForGuards', [GuardController::class, 'getDataForGivingGuads']);
        Route::post('/assignContrct', [GuardController::class, 'contract']);
        Route::get('/getcontract', [GuardController::class, 'getcontracts']);
        Route::get('/deactivateGuard/{id}', [GuardController::class, 'deactiveGuards']);
        Route::get('/firedGuard/{id}', [GuardController::class, 'firedGuard']);
        Route::get('/viewGuard/{id}', [GuardController::class, 'view']);
    });

    // Routes for Service Takers Client
    Route::middleware(['checkUserRole:Taker'])->group(function () {

        Route::get('/dashBoardClient', [DashboardController::class, 'ServiceTaker']);
        Route::get('/get-Portfolios', [Organizations::class, 'getAllPortfolios']);
        Route::get('/get-sidebar', [Organizations::class, 'getClientSidebar']);
        Route::get('/get-client', [RegisterationController::class, 'edit']);
        Route::post('/update-client', [RegisterationController::class, 'update']);
        Route::post('/submit-review', [ReviewController::class, 'AddReview']);
        Route::get('/get-review/{id}', [ReviewController::class, 'getReviews']);
        Route::get('/getContracts', [GuardController::class, 'getClientContracts']);
        Route::get('/GuardsForAttendance', [GuardController::class, 'getGuardsForAttendance']);
        Route::post('/markAttendence',[AttendenceController::class,'saveAttendence']);
        Route::get('/getAttendence/{id}',[AttendenceController::class,'getAttendence']);
        Route::post('/makeMember', [MessageController::class, 'create']);
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
    Route::middleware(['checkUserRole:Guards'])->group(function () {});
});
