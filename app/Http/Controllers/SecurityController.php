<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Security;
use App\Models\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginModel;

class SecurityController extends Controller
{
    public function showLoginForm()
    {
        return view('securityLogin');  // Security login Blade file
    }

    public function showAllApproveUsers()
    {
        $requests = RegistrationRequest::with('user')->where('status', 'approved')->get();

        return view('security.registries', compact('requests'));
    }

    // Show the RFID Activation form
    public function showallUserApproved()
    {
        $approvedUsers = LoginModel::whereHas('registrationRequests', function ($query) {
            $query->where('status', 'approved');
        })->with('vehicles')->get();

        return view('security.rfidActivation', compact('approvedUsers'));
    }

    public function VehicleLogs()
    {
        $approvedUsers = LoginModel::whereHas('registrationRequests', function ($query) {
            $query->where('status', 'approved');
        })->with('vehicles')->get();

        return view('security.vehicleLog', compact('approvedUsers'));
    }


    // Show dashboard
    public function showDashboard()
    {
        $registeredCount = RegistrationRequest::where('status', 'approved')->count();
        $pendingRequestCount = RegistrationRequest::where('status', 'pending')->count();

        return view('security.dashboard', [
            'registeredCount' => $registeredCount,
            'pendingRequestCount' => $pendingRequestCount
        ]);
    }

    // User login for security personnel
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('security')->attempt($credentials)) {
            return redirect()->route('security.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Logout functionality for security personnel
    public function logout()
    {
        Auth::guard('security')->logout();
        return redirect()->route('security.login');
    }
}