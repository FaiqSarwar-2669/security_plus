<?php

use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organizations;

Route::get('/', function () {
    return view('emails.bannedCompany');
});

Route::get('/welcomeMail',function(){
    return view('askingForApproval');
});
Route::get('/viewApplications/{id}', [Organizations::class, 'viewJobApplication']);