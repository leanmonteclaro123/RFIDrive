<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RegistrationRequest; // Import the RegistrationRequest model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showRequests()
    {
        $requests = RegistrationRequest::with('user', 'vehicles', 'documents')->where('status', 'pending')->get();
        return view('admin', compact('requests'));
    }


    public function showLoginForm()
    {
        return view('adminLogin'); // Adjust this if your view is in a different folder
    }

    public function showAllUsersWithRequests()
    {
        $allrequests = RegistrationRequest::with('user', 'vehicles', 'documents')->get();
        return view('admin', compact('requests'));
    }
    
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

        return redirect()->route('admin.requests.index')->with('success', 'Request updated successfully.');
    }

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

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }    


}
