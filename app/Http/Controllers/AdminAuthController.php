<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RegistrationRequest; // Import the RegistrationRequest model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminAuthController extends Controller
{
    public function showProfile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }


    public function showDashboard()
    {
        // Retrieve the required statistics
        $registeredCount = RegistrationRequest::where('status', 'approved')->count();
        $pendingRequestCount = RegistrationRequest::where('status', 'pending')->count();

        // Pass these statistics to the dashboard view
        return view('admin.dashboard', [
            'registeredCount' => $registeredCount,
            'pendingRequestCount' => $pendingRequestCount
        ]);
    }

    // Show pending registration requests
    public function showRequests()
    {
        $requests = RegistrationRequest::with('user') // Only load 'user', no 'vehicles' or 'documents'
            ->where('status', 'pending')
            ->get();
        
        return view('admin.requests', compact('requests'));
    }

    // Show login form
    public function showLoginForm()
    {
        return view('adminLogin'); // Adjust this if your view is in a different folder
    }

    // Show all users with registration requests
    public function showAllUsersWithRequests()
    {
        $requests = RegistrationRequest::with('user')->where('status', 'approved')->get();

        return view('admin.registries', compact('requests'));
    }

    // Update registration request status (approved/rejected)
    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comments' => 'nullable|string',
        ]);

        $registrationRequest = RegistrationRequest::findOrFail($id);
        $registrationRequest->status = $request->status;
        $registrationRequest->admin_id = Auth::guard('admin')->id();
        $registrationRequest->comments = $request->comments;
        $registrationRequest->save();

        return redirect()->route('admin.requests')->with('success', 'Request updated successfully.');
    }

    // Handle admin login
    public function login(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log in the admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        // If login fails, return with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
