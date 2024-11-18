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
        $admin = Auth::guard('admin')->user();

        $requests = RegistrationRequest::with('user');

        // Filter requests based on role
        if ($admin->role === 'super_admin') {
            $requests = $requests->where('status', 'validated');
        } elseif ($admin->role === 'sub_admin') {
            $requests = $requests->where('status', 'pending');
        }

        $requests = $requests->get();

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
            'status' => 'required|in:approved,rejected,validated',
            'comments' => 'nullable|string',
        ]);

        $registrationRequest = RegistrationRequest::findOrFail($id);
        $registrationRequest->status = $request->status;
        $registrationRequest->admin_id = Auth::guard('admin')->id();
         // Only update comments if the status is 'rejected'
        if ($request->status === 'rejected') {
            $registrationRequest->comments = $request->comments;
        } else {
            $registrationRequest->comments = null; // Clear previous comments if any
        }

        $registrationRequest->save();

        return redirect()->route('admin.requests')->with('success', 'Request updated successfully.');
    }

    //return redirect()->intended('/admin/dashboard');

    // Handle admin login
    public function login(Request $request)
    {
        // Validate credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to find the admin by email
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Log in with the appropriate guard
            if ($admin->role === 'super_admin') {
                Auth::guard('super_admin')->login($admin);
                return redirect()->intended('/admin/dashboard');
            } elseif ($admin->role === 'sub_admin') {
                Auth::guard('sub_admin')->login($admin);
                return redirect()->intended('/admin/dashboard');
            }
        }

        // If login fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }




    // Handle admin logout
    public function logout(Request $request)
    {
        if (Auth::guard('super_admin')->check()) {
            Auth::guard('super_admin')->logout();
        } elseif (Auth::guard('sub_admin')->check()) {
            Auth::guard('sub_admin')->logout();
        }

        return redirect()->route('admin.login');
    }


}
