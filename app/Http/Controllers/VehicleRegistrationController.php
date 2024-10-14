<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Document;
use App\Models\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRegistrationController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!$user->driver_license_front || !$user->driver_license_back || !$user->driver_license_expiry_date) {
            return view('vehicleRegistration', compact('user'))->with('incomplete_profile', true);
        }

        return view('vehicleRegistration', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'vehicles.*.vehicle_type' => 'required|string|in:fueled_vehicle,electronic_vehicle',
            'vehicles.*.license_plate' => 'nullable|string|max:255',
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
            'documents.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documents.*.expiry_date' => 'nullable|date',
        ]);

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
                'vehicle_type' => $vehicleData['vehicle_type'],
                'license_plate' => $vehicleData['vehicle_type'] === 'fueled_vehicle' ? $vehicleData['license_plate'] : null,
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

            $orIndex = $index * 3;
            $crIndex = $orIndex + 1;
            $supportDocIndex = $index === 0 ? 2 : 5;
            $certificateIndex = $index === 0 ? 6 : 7; // Index for certificate of ownership based on Blade template

            if ($vehicleData['vehicle_type'] === 'fueled_vehicle') {
                if ($request->hasFile("documents.$orIndex.file")) {
                    $document = Document::create([
                        'vehicle_id' => $vehicle->id,
                        'type' => 'Official Receipt',
                        'file_path' => $request->file("documents.$orIndex.file")->store('documents', 'public'),
                        'expiry_date' => $request->input("documents.$orIndex.expiry_date"),
                    ]);
                    $documentIds[] = $document->id;
                }

                if ($request->hasFile("documents.$crIndex.file")) {
                    $document = Document::create([
                        'vehicle_id' => $vehicle->id,
                        'type' => 'Certificate of Registration',
                        'file_path' => $request->file("documents.$crIndex.file")->store('documents', 'public'),
                    ]);
                    $documentIds[] = $document->id;
                }
            } elseif ($vehicleData['vehicle_type'] === 'electronic_vehicle') {
                if ($request->hasFile("documents.$certificateIndex.file")) {
                    $document = Document::create([
                        'vehicle_id' => $vehicle->id,
                        'type' => 'Certificate of Ownership',
                        'file_path' => $request->file("documents.$certificateIndex.file")->store('documents', 'public'),
                    ]);
                    $documentIds[] = $document->id;
                }
            }
            // Handle Support Document if exists
            if ($request->hasFile("documents.$supportDocIndex.file")) {
                $document = Document::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => 'Support Document',
                    'file_path' => $request->file("documents.$supportDocIndex.file")->store('documents', 'public'),
                ]);
                $documentIds[] = $document->id;
            }
        }

        $registrationRequest->update([
            'vehicle_ids' => json_encode($vehicleIds),
            'document_ids' => json_encode($documentIds),
        ]);

        return redirect()->route('home')->with('success', 'Vehicle registered successfully.');
    }
}
