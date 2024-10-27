<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class RFIDController extends Controller
{
    /**
     * Handle RFID tag check.
     */
    public function storeRFID(Request $request)
{
    $rfidTag = $request->input('rfid_tag');
    if ($rfidTag) {
        return response()->json(['success' => 'RFID received', 'rfid_tag' => $rfidTag], 200);
    } else {
        return response()->json(['error' => 'No RFID tag provided'], 400);
    }
}

}
