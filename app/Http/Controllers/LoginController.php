<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PSGCController;
use App\Models\LoginModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends Controller
{
    use ValidatesRequests;

    // Show registration form with provinces
    public function showRegistrationForm()
    {
        $psgcController = new PSGCController();
        $provincesResponse = $psgcController->getProvinces();
        $provinces = $provincesResponse->getData();

        return view('login', ['provinces' => $provinces]);
    }

    // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'telephone' => 'required|string|max:11',
            'province' => 'required|string|max:255',
            'municipal' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'type' => 'required|string|max:255',
            'codeID' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:login_models',
            'email' => 'required|string|email|max:255|unique:login_models',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = LoginModel::create([
            'role' => $request->role ?? 'User',
            'full_name' => $request->full_name,
            'telephone' => $request->telephone,
            'province' => $request->province,
            'municipal' => $request->municipal,
            'barangay' => $request->barangay,
            'zipcode' => $request->zipcode,
            'type' => $request->type,
            'codeID' => $request->codeID,
            'campus' => $request->campus ?? 'Batangas State University ARASOF Nasugbu',
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    // Display user details on landing page
    public function landing()
    {
        return view('landing', ['user' => Auth::user()]);
    }

    // Login user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('landing')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->withErrors(['password' => 'The provided password is incorrect.'])->withInput();
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing')->with('success', 'Logged out successfully!');
    }

    // Show user profile
    public function showProfile()
    {
        $user = Auth::user();

        if ($user) {
            return view('landingProfile', compact('user'));
        }

        return redirect()->route('login')->with('error', 'You need to be logged in to register a vehicle.');
    }
}
