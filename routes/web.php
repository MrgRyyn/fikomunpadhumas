<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function() {
    if (Session::has('npm')) {
        return redirect('vote');
    }
    return view('login');
});

Route::get('otp', function() {
    if (!Session::has('npm')) {
        return redirect('login')->with('error', 'NPM not found in session.');
    }
    return view('otp');
});

Route::post('/kirim-otp', [OTPController::class, 'sendOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);
Route::post('/submit-vote', [VoteController::class, 'storeVote']);

Route::get('vote', function() {
    return view('dashboard.vote');
})->middleware(LoginMiddleware::class);

Route::get('logout', function() {
    Session::flush();
    return redirect('/')->with('success', 'Logged out successfully.');
});

Route::get('admin', [DashboardController::class, 'index'])->middleware(LoginMiddleware::class);
