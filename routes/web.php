<?php

use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcomeMail',function(){
    return view('welcomeMail');
});