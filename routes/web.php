<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PSGCController;
use App\Http\Controllers\LoginController;

// Landing page is accessible by everyone (no authentication required)
Route::get('/', [LoginController::class, 'landing'])->name('landing');

// Login page is only accessible to guests (non-authenticated users)
Route::get('/login', function() {
    return view('login');
})->name('login')->middleware('guest');

// Registration routes also only accessible to guests
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// PSGC Routes (publicly accessible)
Route::get('/provinces', [PSGCController::class, 'getProvinces']);
Route::get('/municipalities/{provinceCode}', [PSGCController::class, 'getMunicipalities']);
Route::get('/barangays/{municipalityCode}', [PSGCController::class, 'getBarangays']);
Route::get('/zipcode', [PSGCController::class, 'getZipCode']);

// Landing page route
Route::get('/landinghome', function() {
    return view('landing');
})->name('home');

// Guidelines page route
Route::get('/guidelines', function() {
    return view('guidelines');
})->name('guidelines');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Vehicle Registration page, accessible only when logged in
    Route::get('/vehicle-registration', [LoginController::class, 'showVehicleRegistrationForm'])->name('vehicle.registration');
});

// Admin route
Route::get('/admin', function() {
    return view('admin');
})->name('admin');
