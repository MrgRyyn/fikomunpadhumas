<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function() {
    return view('login');
});


Route::get('otp', function() {
    return view('otp');
});

Route::get('vote', function() {
    return view('vote');
});

Route::get('admin', function() {
    return view('/admin/admin');
});

