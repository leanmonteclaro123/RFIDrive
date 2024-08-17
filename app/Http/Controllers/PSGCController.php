<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PSGCController extends Controller
{
    protected $zipcodes; // Declare the property

    public function __construct()
    {
        // Load the zipcode data once when the controller is initialized
        $this->zipcodes = json_decode(file_get_contents(resource_path('data/zipcodes.json')), true);
    }

    public function getProvinces()
    {
        $response = Http::get('https://psgc.gitlab.io/api/provinces/');
        return response()->json($response->json());
    }

    public function getMunicipalities($provinceCode)
    {
        $response = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/");
        return response()->json($response->json());
    }

    public function getBarangays($municipalityCode)
    {
        $response = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$municipalityCode}/barangays/");
        
        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch barangays'], $response->status());
        }
    }

    public function getZipCode(Request $request)
    {
        $municipality = strtolower($request->query('municipality'));

        // Search for the zip code in the JSON data
        foreach ($this->zipcodes as $zipcode => $places) {
            // Handle the case where a single zip code maps to multiple places
            if (is_array($places)) {
                foreach ($places as $place) {
                    if (strtolower($place) == $municipality) {
                        return response()->json(['zipcode' => $zipcode]);
                    }
                }
            } else {
                // Handle the case where a single zip code maps to a single place
                if (strtolower($places) == $municipality) {
                    return response()->json(['zipcode' => $zipcode]);
                }
            }
        }

        return response()->json(['error' => 'No Zip Code Found'], 404);
    }
}
