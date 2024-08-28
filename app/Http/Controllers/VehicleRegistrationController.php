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

        // Only validate the documents that have been submitted
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
            'documents.*.file' => 'nullable|file|mimes:jpg,jpeg,png',
            'documents.*.expiry_date' => 'nullable|date',
        ]);

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

            // Filter the relevant documents for this vehicle
            $vehicleDocuments = array_filter($validated['documents'], function ($doc) use ($index) {
                return in_array($doc['type'], ['Driver License', 'OR']);
            });

            foreach ($vehicleDocuments as $docData) {
                Document::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => $docData['type'],
                    'file_path' => $docData['file']->store('documents'),
                    'expiry_date' => $docData['expiry_date'],
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Vehicle registered successfully.');
    }

    

}

