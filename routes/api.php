<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RFIDController;
use App\Http\Controllers\SecurityController;

// Define the API route for checking RFID

Route::middleware([])->post('/rfid', [RFIDController::class, 'storeRFID']);
