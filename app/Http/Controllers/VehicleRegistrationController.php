<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRegistrationController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user) {
            return view('vehicleRegistration', compact('user'));
        }

        return redirect()->route('login')->with('error', 'You need to be logged in to register a vehicle.');
    }

    public function store(Request $request)
{
    $user = Auth::user();

    if ($user->vehicles()->count() >= 2) {
        return redirect()->back()->withErrors(['limit' => 'You can only register up to two vehicles.']);
    }

    // Validate the request
    $validated = $request->validate([
        'vehicles.*.license_plate' => 'required|string|max:255',
        'vehicles.*.province' => 'required|string|max:255',
        'vehicles.*.make' => 'required|string|max:255',
        'vehicles.*.model' => 'required|string|max:255',
        'vehicles.*.year' => 'required|integer',
        'vehicles.*.color' => 'required|string|max:255',
        'vehicles.*.registered_owner_name' => 'required|string|max:255',
        'vehicles.*.registered_owner_province' => 'required|string|max:255',
        'vehicles.*.registered_owner_municipality' => 'required|string|max:255',
        'vehicles.*.registered_owner_barangay' => 'required|string|max:255',
        'vehicles.*.registered_owner_zipcode' => 'required|string|max:10',
        'documents.*.file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'documents.*.expiry_date' => 'nullable|date',
    ]);

    $driverLicenseData = null; // to hold the driver's license data for both vehicles

    foreach ($validated['vehicles'] as $index => $vehicleData) {
        $vehicle = Vehicle::create([
            'user_id' => $user->id,
            'license_plate' => $vehicleData['license_plate'],
            'province' => $vehicleData['province'],
            'make' => $vehicleData['make'],
            'model' => $vehicleData['model'],
            'year' => $vehicleData['year'],
            'color' => $vehicleData['color'],
            'registered_owner_name' => $vehicleData['registered_owner_name'],
            'registered_owner_province' => $vehicleData['registered_owner_province'],
            'registered_owner_municipality' => $vehicleData['registered_owner_municipality'],
            'registered_owner_barangay' => $vehicleData['registered_owner_barangay'],
            'registered_owner_zipcode' => $vehicleData['registered_owner_zipcode'],
        ]);

        // Handle Driver License (common for both vehicles)
        if ($index === 0 && isset($validated['documents'][0]['file'])) {
            // Store driver's license details for both vehicles
            $file = $validated['documents'][0]['file'];
            $filePath = $file->store('documents');

            $driverLicenseData = [
                'file_path' => $filePath,
                'expiry_date' => $validated['documents'][0]['expiry_date'] ?? null,
            ];

            Document::create([
                'vehicle_id' => $vehicle->id,
                'type' => 'Driver License',
                'file_path' => $filePath,
                'expiry_date' => $driverLicenseData['expiry_date'],
            ]);
        } elseif ($index === 1 && $driverLicenseData) {
            // For the second vehicle, just copy the driver's license data
            Document::create([
                'vehicle_id' => $vehicle->id,
                'type' => 'Driver License',
                'file_path' => $driverLicenseData['file_path'],
                'expiry_date' => $driverLicenseData['expiry_date'],
            ]);
        }

        // Handle OR and CR documents for each vehicle
        $orIndex = $index === 0 ? 2 : 4;
        $crIndex = $orIndex + 1;

        $orExpiryDate = null;

        // Handle OR for each vehicle
        if (isset($validated['documents'][$orIndex]['file'])) {
            $file = $validated['documents'][$orIndex]['file'];
            $filePath = $file->store('documents');
            $orExpiryDate = $validated['documents'][$orIndex]['expiry_date'] ?? null;

            Document::create([
                'vehicle_id' => $vehicle->id,
                'type' => 'OR',
                'file_path' => $filePath,
                'expiry_date' => $orExpiryDate,
            ]);
        }

        // Handle CR for each vehicle and set the expiry date based on the OR expiry date
        if (isset($validated['documents'][$crIndex]['file'])) {
            $file = $validated['documents'][$crIndex]['file'];
            $filePath = $file->store('documents');

            Document::create([
                'vehicle_id' => $vehicle->id,
                'type' => 'CR',
                'file_path' => $filePath,
                'expiry_date' => $orExpiryDate, // Use OR's expiry date
            ]);
        }
    }

    return redirect()->route('home')->with('success', 'Vehicle registered successfully.');
}

    

    


}
