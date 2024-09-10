<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Document;
use App\Models\RegistrationRequest;
use App\Models\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRegistrationController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // Check if driver's license data is missing
        if (!$user->driver_license_front || !$user->driver_license_back || !$user->driver_license_expiry_date) {
        return view('vehicleRegistration', compact('user'))->with('incomplete_profile', true);
        }

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

        // Create the registration request
        $registrationRequest = RegistrationRequest::create([
            'user_id' => $user->id,
            'type' => 'vehicle_registration',
            'status' => 'pending',
        ]);

        $vehicleIds = [];
        $documentIds = [];

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

            $vehicleIds[] = $vehicle->id;

            // Handle OR and CR documents
            $orIndex = $index * 2; // OR is the first document for this vehicle
            $crIndex = $orIndex + 1; // CR is the second document for this vehicle

            $orExpiryDate = null;

            if (isset($validated['documents'][$orIndex]['file'])) {
                $file = $validated['documents'][$orIndex]['file'];
                $filePath = $file->store('documents', 'public');

                $orExpiryDate = $validated['documents'][$orIndex]['expiry_date'] ?? null;

                $document = Document::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => 'OR',
                    'file_path' => $filePath, // Prefix with 'storage/' to access it via a public URL
                    'expiry_date' => $orExpiryDate,
                ]);

                $documentIds[] = $document->id;
            }

            if (isset($validated['documents'][$crIndex]['file'])) {
                $file = $validated['documents'][$crIndex]['file'];
                $filePath = $file->store('documents','public');

                $document = Document::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => 'CR',
                    'file_path' => $filePath, // Prefix with 'storage/' to access it via a public URL
                    'expiry_date' => $orExpiryDate, // Set CR expiry date the same as OR
                ]);

                $documentIds[] = $document->id;
            }
        }

        // Save the vehicle and document IDs to the registration request
        $registrationRequest->update([
            'vehicle_ids' => json_encode($vehicleIds),
            'document_ids' => json_encode($documentIds),
        ]);

        return redirect()->route('home')->with('success', 'Vehicle registered successfully.');
    }
}
