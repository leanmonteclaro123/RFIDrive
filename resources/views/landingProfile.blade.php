@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<section class="home-content">
    <div class="container home-section" id="profile">
        <div id="profile" class="card profile-settings shadow-lg p-4 mb-5 bg-white rounded">
            <div class="profile-header text-center">
                <h2>Account Settings</h2>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <!-- Avatar display only, no upload functionality -->
                    <div class="avatar text-center mb-4">
                        <img id="avatarImage" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User Avatar">
                    </div>
                    <form id="profileForm">
                        <div class="form-group mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control" id="name" value="{{ $user->full_name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone" value="{{ $user->telephone }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ $user->username }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                        </div>

                        <!-- Old Password Verification -->
                        <div id="passwordVerificationSection" class="form-group mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="oldPassword" placeholder="Enter current password">
                            <button type="button" class="btn btn-primary mt-2" id="verifyPasswordBtn">Verify Password</button>
                            <div id="passwordVerificationMessage" class="mt-2"></div>
                        </div>

                        <!-- Hidden Change Password Section -->
                        <div id="changePasswordSection" style="display: none;">
                            <div class="form-group mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                            </div>

                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{ asset('css/landingProfile.css') }}">

<script>
    document.getElementById('verifyPasswordBtn').addEventListener('click', function() {
        const oldPassword = document.getElementById('oldPassword').value;

        // Simulate AJAX call to verify the old password
        if (oldPassword === 'correct_password') { // Replace with actual AJAX call to your backend
            document.getElementById('passwordVerificationMessage').innerHTML = `
                <p class="text-success">Password verified! A confirmation email has been sent.</p>`;
            
            // Simulate email confirmation and reveal change password fields
            setTimeout(function() {
                document.getElementById('changePasswordSection').style.display = 'block';
                document.getElementById('passwordVerificationSection').style.display = 'none';
            }, 3000); // Simulate delay for email confirmation
        } else {
            document.getElementById('passwordVerificationMessage').innerHTML = `
                <p class="text-danger">Incorrect password. Please try again.</p>`;
        }
    });
</script>

@endsection
