@extends('layouts.adminLayout')

@section('title', 'Profile')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminProfile.css') }}">
@endpush

@section('content')
    <!-- Profile Content -->
    <div id="profile" class="content-section profile-settings" >
        <h2>Account Settings</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="avatar">
                    <img id="avatarImage" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User Avatar">
                </div>
                <div class="upload-reset-container mt-3">
                    <div class="upload-btn-wrapper">
                        <button class="btn btn-primary btn-sm">Upload Photo</button>
                        <input type="file" name="avatar" accept="image/*" onchange="loadFile(event)">
                    </div>
                    <button class="btn btn-secondary btn-sm" id="resetButton">Reset</button>
                </div>
            </div>
            
            <div class="col-md-9">
                <form id="profileForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="nmaxwell">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="Nelle Maxwell">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" value="nmaxwell@mail.com">
                        <small class="text-warning">Your email is not confirmed. Please check your inbox.</small>
                        <a href="#" class="text-primary">Resend confirmation</a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter new password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
