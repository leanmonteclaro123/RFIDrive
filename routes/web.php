<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PSGCController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleRegistrationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Api\RFIDController;

// Landing page accessible by everyone
Route::get('/', [LoginController::class, 'landing'])->name('landing');

// Guest routes for user login and registration
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post'); // For regular user login
    
});

// Logout route (user authentication)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Publicly accessible PSGC routes
Route::get('/provinces', [PSGCController::class, 'getProvinces']);
Route::get('/municipalities/{provinceCode}', [PSGCController::class, 'getMunicipalities']);
Route::get('/barangays/{municipalityCode}', [PSGCController::class, 'getBarangays']);
Route::get('/zipcode', [PSGCController::class, 'getZipCode']);

// Static pages
Route::view('/landinghome', 'landing')->name('home');
Route::view('/guidelines', 'guidelines')->name('guidelines');

// Routes requiring user authentication
Route::middleware('auth')->group(function () {
    // Vehicle Registration routes
    Route::get('/vehicle-registration', [VehicleRegistrationController::class, 'create'])->name('vehicle.registration');
    Route::post('/vehicle-registration', [VehicleRegistrationController::class, 'store'])->name('vehicle.registration.store');

    Route::get('/vehicle-renewal', [VehicleRegistrationController::class, 'recreate'])->name('vehicle.renew');
    
    // Profile routes
    Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Admin login routes
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');

    // Routes for Super Admin
    Route::middleware('admin.role:super_admin')->group(function () {
        Route::get('/requests', [AdminAuthController::class, 'showRequests'])->name('super.admin.requests');
        Route::patch('/requests/{id}', [AdminAuthController::class, 'updateRequestStatus'])->name('super.admin.requests.update');
        Route::get('/registries', [AdminAuthController::class, 'showAllUsersWithRequests'])->name('super.admin.registries');
    });

    // Routes for Sub Admin
    Route::middleware('admin.role:sub_admin')->group(function () {
        Route::get('/requests', [AdminAuthController::class, 'showRequests'])->name('sub.admin.requests');
        Route::patch('/requests/{id}', [AdminAuthController::class, 'updateRequestStatus'])->name('sub.admin.requests.update');
    });

    // Shared routes
    Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('admin.profile');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


// Security login routes
Route::prefix('security')->middleware('guest:security')->group(function () {
    Route::get('/login', [SecurityController::class, 'showLoginForm'])->name('security.login');
    Route::post('/login', [SecurityController::class, 'login'])->name('security.login.post');
});

// Security-specific routes
Route::prefix('security')->middleware('auth:security')->group(function () {
    Route::get('/dashboard', [SecurityController::class, 'showDashboard'])->name('security.dashboard');
    Route::get('/registries', [SecurityController::class, 'showAllApproveUsers'])->name('security.registries');
    Route::post('/logout', [SecurityController::class, 'logout'])->name('security.logout');

    // New route for searching stakeholders
    Route::get('/search-stakeholders', [SecurityController::class, 'searchStakeholders'])->name('security.search.stakeholders');
    Route::get('/rfid-activation', [SecurityController::class, 'showallUserApproved'])->name('security.rfid.form');
    Route::get('/vehicleLogs', [SecurityController::class, 'VehicleLogs'])->name('security.vehicle.form');


});





