<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PSGCController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleRegistrationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;

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
    // Vehicle Registration routes
    Route::get('/vehicle-registration', [VehicleRegistrationController::class, 'create'])->name('vehicle.registration');
    Route::post('/vehicle-registration', [VehicleRegistrationController::class, 'store'])->name('vehicle.registration.store');
    
    // Profile route
    Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // Routes that require admin authentication
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'showRequests'])->name('admin.dashboard');
        Route::patch('/requests/{id}', [AdminAuthController::class, 'updateRequestStatus'])->name('admin.requests.update');
        
    });
});

// If needed, public route for admin requests
Route::get('/admin/requests', [AdminAuthController::class, 'showRequests'])->name('admin.requests.index');
Route::patch('/admin/requests/{id}', [AdminAuthController::class, 'updateRequestStatus'])->name('admin.requests.update');
// Route::get('/admin/registries', [AdminAuthController::class, 'showApprovedRegistries'])->name('admin.registries');
// Updated route for showing all users with registration requests
Route::get('/admin/registries', [AdminAuthController::class, 'showAllUsersWithRequests'])->name('admin.registries');

