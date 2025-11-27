<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function() {
    // If already authenticated, redirect to vote page
    if (Auth::check()) {
        return redirect('vote');
    }
    return view('login');
});



Route::post('/kirim-otp', [OTPController::class, 'sendOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);
Route::post('/submit-vote', [VoteController::class, 'storeVote'])->middleware(LoginMiddleware::class);

Route::get('vote', function() {
    return view('dashboard.vote');
})->middleware(LoginMiddleware::class);

Route::get('otp', function () {
    if (request()->query('redirect-from') !== 'login') {
        return redirect('login')->with('error', 'Please log in to access the OTP page.');
    }
    return view('otp');
});

Route::get('logout', function() {
    Session::flush();
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully.');
});

Route::get('admin', [DashboardController::class, 'index'])->middleware(LoginMiddleware::class);
