<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RFIDController;

// Define the POST route for RFID activation, handled by RFIDController
Route::post('/rfid/activate', [RFIDController::class, 'store']);



// Define the GET route for fetching the latest RFID tag
Route::get('/rfid/latest', [RFIDController::class, 'getLatestTag']);
