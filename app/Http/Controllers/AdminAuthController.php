<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RegistrationRequest; // Import the RegistrationRequest model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminAuthController extends Controller
{

    // Show login form
    public function showLoginForm()
    {
        return view('adminLogin'); // Adjust this if your view is in a different folder
    }

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

    // Super Admin-specific requests
    public function superAdminRequests()
    {
        $requests = RegistrationRequest::with('user')
            ->where('status', 'validated') // Fetch validated requests
            ->get();

        return view('admin.requests', compact('requests'));
    }

    // Sub Admin-specific requests
    public function subAdminRequests()
    {
        $requests = RegistrationRequest::with('user')
            ->where('status', 'pending') // Sub Admin views pending requests
            ->get();

        return view('admin.requests', compact('requests'));
    }

    // Show all users with registration requests
    public function showAllUsersWithRequests()
    {
        $requests = RegistrationRequest::with('user')->where('status', 'approved')->get();

        return view('admin.registries', compact('requests'));
    }

    // Update request status
    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,validated',
            'comments' => 'nullable|string',
        ]);

        $registrationRequest = RegistrationRequest::findOrFail($id);
        $registrationRequest->status = $request->status;
        $registrationRequest->admin_id = Auth::guard('admin')->id();

        if ($request->status === 'rejected') {
            $registrationRequest->comments = $request->comments;
        } else {
            $registrationRequest->comments = null; // Clear comments for non-rejected statuses
        }

        $registrationRequest->save();

        return redirect()->route('admin.requests')->with('success', 'Request updated successfully.');
    }

    //return redirect()->intended('/admin/dashboard');

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }




    // Handle admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }


}
