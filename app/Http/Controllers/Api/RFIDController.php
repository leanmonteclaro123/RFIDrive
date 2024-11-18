<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle; // Assuming Vehicle is the model where RFID tags are stored

class RFIDController extends Controller
{
    /**
     * Store the RFID tag for a specific vehicle.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'rfid_tag' => 'required|string',
            'vehicle_id' => 'required|exists:vehicles,id'
        ]);

        // Find the vehicle by ID
        $vehicle = Vehicle::find($request->vehicle_id);

        // Update the vehicle's RFID tag
        $vehicle->rfid_tag = $request->rfid_tag;
        $vehicle->save();

        // Return a success response
        return response()->json(['status' => 'success', 'message' => 'RFID tag successfully stored for the vehicle']);
    }

    /**
     * Get the latest RFID tag (for polling or other purposes).
     */
    public function getLatestTag()
    {
        // Fetch the latest vehicle with an RFID tag (if applicable)
        $latestVehicle = Vehicle::whereNotNull('rfid_tag')->latest('updated_at')->first();
        
        return response()->json(['rfid_tag' => $latestVehicle ? $latestVehicle->rfid_tag : null]);
    }
}
