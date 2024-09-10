<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Handle profile update submission
    public function update(Request $request)
    {
        // Validate the input data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'driver_license_front' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'driver_license_back' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'driver_license_expiry_date' => 'required|date',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Profile picture validation
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user = Auth::user();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old file if it exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_picture));
            }

            // Store the new profile picture in the public disk
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = 'storage/' . $profilePicturePath;
        }

        // Handle driver license upload
        if ($request->hasFile('driver_license_front')) {
            // Delete the old file if it exists
            if ($user->driver_license_front) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->driver_license_front));
            }

            $user->driver_license_front = $request->file('driver_license_front')->store('driver_licenses', 'public');
        }

        if ($request->hasFile('driver_license_back')) {
            // Delete the old file if it exists
            if ($user->driver_license_back) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->driver_license_back));
            }

            $user->driver_license_back = $request->file('driver_license_back')->store('driver_licenses', 'public');
        }

        // Update other fields
        $user->full_name = $request->input('full_name');
        $user->telephone = $request->input('telephone');
        $user->username = $request->input('username');
        $user->driver_license_expiry_date = $request->input('driver_license_expiry_date');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save changes
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


}
