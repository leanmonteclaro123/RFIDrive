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
                    <!-- Profile form to update user information -->
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Avatar display with Camera icon -->
                        <div class="avatar-container">
                            <!-- Profile picture preview -->
                            <img id="avatarImage" 
                            src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('images/default-avatar.jpg') }}" 
                            alt="User Avatar" 
                            class="img-preview" 
                            style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">

                            <!-- Camera Icon for profile picture upload -->
                            <label for="profilePictureInput" class="camera-icon">
                                <i class="fas fa-camera"></i>
                            </label>
                            
                            <!-- Hidden file input for profile picture upload -->
                            <input type="file" id="profilePictureInput" name="profile_picture" accept=".jpg, .jpeg, .png" style="display: none;" onchange="previewProfilePicture(this)">
                        </div>

                        <!-- Full Name -->
                        <div class="form-group mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}" required>
                        </div>

                        <!-- Telephone -->
                        <div class="form-group mb-3">
                            <label class="form-label">Telephone</label>
                            <input type="text" class="form-control" name="telephone" value="{{ $user->telephone }}" required>
                        </div>

                        <!-- Username -->
                        <div class="form-group mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                        </div>

                        <!-- Email (read-only) -->
                        <div class="form-group mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
                        </div>

                        <!-- Driver's License Uploads -->
                        <div class="upload-grid">
                            <!-- Front License Upload -->
                            <div class="upload-group" data-label="Driver_License-front">
                                <input name="driver_license_front" type="file" id="dl-reg-front" class="form-control-file" accept=".jpg, .jpeg, .png" onchange="previewFile('dl-reg-front', 'driver-license-front-preview')">
                                
                                <!-- Display previously uploaded front license or show an empty preview box -->
                                @if($user->driver_license_front)
                                    <img id="driver-license-front-preview" src="{{ asset($user->driver_license_front) }}" alt="Driver License Front" class="img-preview"  onclick="openImageModal(this)">
                                @else
                                    <img id="driver-license-front-preview" class="img-preview" style="display:none;" onclick="openImageModal(this)">
                                @endif
                                
                                <label for="dl-reg-front">
                                    <i class="fas fa-upload"></i>
                                    <span>Driver License (Front)</span>
                                </label>
                            </div>

                            <!-- Back License Upload -->
                            <div class="upload-group" data-label="Driver_License-back">
                                <input name="driver_license_back" type="file" id="dl-reg-back" class="form-control-file" accept=".jpg, .jpeg, .png" onchange="previewFile('dl-reg-back', 'driver-license-back-preview')">
                                
                                <!-- Display previously uploaded back license or show an empty preview box -->
                                @if($user->driver_license_back)
                                    <img id="driver-license-back-preview" src="{{ asset($user->driver_license_back) }}" alt="Driver License Back" class="img-preview"  onclick="openImageModal(this)">
                                @else
                                    <img id="driver-license-back-preview" class="img-preview" style="display:none;" onclick="openImageModal(this)">
                                @endif
                                
                                <label for="dl-reg-back">
                                    <i class="fas fa-upload"></i>
                                    <span>Driver License (Back)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Driver's License Expiry Date -->
                        <div class="form-group mb-3">
                            <label class="form-label">Driver's License Expiry Date</label>
                            <input type="date" class="form-control" name="driver_license_expiry_date" value="{{ $user->driver_license_expiry_date }}" required>
                        </div>

                        <!-- Password Change Section (optional) -->
                        <div id="passwordSection" class="form-group mb-3">
                            <label class="form-label">Change Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter new password">
                            <input type="password" class="form-control mt-2" name="password_confirmation" placeholder="Confirm new password">
                        </div>

                        <!-- Save Changes Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<div id="imagePreviewModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" style="max-width: 100%; height: auto;">
    </div>
</div>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/landingProfile.css') }}">

<!--=======SCRIPT=======-->
<script src="{{asset('js/profile.js')}}"></script>

@endsection
