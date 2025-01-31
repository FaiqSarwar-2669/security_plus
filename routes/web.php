<?php

use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organizations;
use App\Http\Controllers\paymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcomeMail', function () {
    return view('Update');
});
Route::get('/viewApplications/{id}', [Organizations::class, 'viewJobApplication']);

Route::get('/payment', function () {
    return view('payment');
});

Route::post('/process-payment', [paymentController::class, 'processPayment'])->name('process.payment');
