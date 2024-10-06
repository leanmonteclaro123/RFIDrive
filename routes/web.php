<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PSGCController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleRegistrationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;

// Landing page accessible by everyone
Route::get('/', [LoginController::class, 'landing'])->name('landing');

// Guest routes for login and registration
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
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
    
    // Profile routes
    Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes with prefix
Route::prefix('admin')->group(function () {
    // Guest routes for admin login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); 
    
    // Routes requiring admin authentication
    Route::middleware('auth:admin')->group(function () {
        // Admin dashboard
        Route::get('/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');

        // Requests table (registration requests)
        Route::get('/requests', [AdminAuthController::class, 'showRequests'])->name('admin.requests');
        Route::get('/admin/requests', [AdminAuthController::class, 'showRequests'])->name('admin.requests.index');

        Route::patch('/requests/{id}', [AdminAuthController::class, 'updateRequestStatus'])->name('admin.requests.update');

        // Registries table (show all users with registration requests)
        Route::get('/registries', [AdminAuthController::class, 'showAllUsersWithRequests'])->name('admin.registries');

        // Admin profile route
        Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('admin.profile'); // Define the admin profile route here
    });
});

Route::get('/security', function () {
    return view('PersonnelLayout');
})->name('PersonnelLayout');
