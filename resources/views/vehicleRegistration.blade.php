@extends('layouts.app')

@section('title', 'Vehicle Registration Form')

@section('content')
<section class="home-content">
    <div class="container home-section" id="registration">
        <div class="card register-container shadow-lg p-4 mb-5 bg-white rounded">

            <!-- Error Display Section -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
                <div class="registration-header text-center">
                    <h2>VEHICLE REGISTRATION FORM</h2>
                    <p>Please complete all required fields and use CamScanner to capture documents </p>
                </div>

                <!-- Personal Information -->
                <div class="card shadow-sm mb-4 p-3">
                    <h4>Personal Information</h4>
                    <div class="form-group">
                        <label for="full-name">Full Name <span class="text-danger">*</span>:</label>
                        <input type="text" id="full-name" class="form-control" readonly value="{{ $user->full_name }}" placeholder="Enter Full Name">
                    </div>

                    <div class="two-box form-row">
                        <div class="col-md-6 mb-3">
                            <label for="role">Role <span class="text-danger">*</span>:</label>
                            <input type="text" id="role" class="form-control" readonly value="{{ $user->type }}"  placeholder="Enter Role">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id">ID <span class="text-danger">*</span>:</label>
                            <input type="text" id="id" class="form-control" readonly value="{{ $user->codeID ?? 'N/A' }}" placeholder="Enter ID">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Telephone <span class="text-danger">*</span>:</label>
                        <input type="text" id="telephone" class="form-control" readonly value="{{ $user->telephone }}" placeholder="Enter Telephone#">
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span class="text-danger">*</span>:</label>
                        <input type="text" id="address" class="form-control" readonly value="{{ $user->barangay }}, {{ $user->municipal }}, {{ $user->province }}" placeholder="Enter Current Address">
                    </div>
                    <div class="form-group">
                        <label for="campus">Campus <span class="text-danger">*</span>:</label>
                        <input type="text" id="campus" class="form-control" value="{{ $user->campus }}" readonly placeholder="Enter Campus">
                    </div> 

                    <div class="upload-grid">
                        <div class="upload-group" data-label="Driver_License-front">
                            @if($user->driver_license_front)
                                    <img id="driver-license-front-preview" src="{{ asset($user->driver_license_front) }}" alt="Driver License Front" class="img-preview"  onclick="openImageModal(this)">
                                @else
                                    <img id="driver-license-front-preview" class="img-preview" style="display:none;" onclick="openImageModal(this)">
                                @endif
                            <img id="dl-reg-preview-front" class="img-preview" style="display:none;" alt="Driver License Front Preview">
                            <label for="dl-reg-front">
                                <span>Driver License (Front)</span>
                            </label>
                        </div>
                           
                        <div class="upload-group" data-label="Driver_License-back">
                            @if($user->driver_license_back)
                                    <img id="driver-license-back-preview" src="{{ asset($user->driver_license_back) }}" alt="Driver License Back" class="img-preview" onclick="openImageModal(this)">
                                @else
                                    <img id="driver-license-back-preview" class="img-preview" style="display:none;" onclick="openImageModal(this)">
                                @endif
                            <img id="dl-reg-preview-back" class="img-preview" style="display:none;" alt="Driver License Back Preview">
                            <label for="dl-reg-back">
                                <span>Driver License (Back)</span>
                            </label>
                        </div>
                    </div>
                    <div class="class form-grup">
                        <label for="driver_license_expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span>:</label>
                        <input type="date" class="form-control" name="driver_license_expiry_date" value="{{ $user->driver_license_expiry_date }}" required>
                    </div>
                </div>
            
            <form id="vehicle-registration-form" action="{{ route('vehicle.registration.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Vehicle Information -->
                <div class="form-content" id="vehicle-sections">
                    <!-- Initial Vehicle Information (Vehicle 1) -->
                    <div class="card shadow-sm mb-4 p-3 vehicle-section" id="vehicle-section-1">
                        <h4>Vehicle Information (Vehicle 1)</h4>
                        <div class="form-group">
                            <label for="license-plate-number-1">License Plate No. <span class="text-danger">*</span>:</label>
                            <input name="vehicles[0][license_plate]" type="text" id="license-plate-number-1" class="form-control" required placeholder="Enter License Plate No.">
                        </div>
                        <div class="form-group">
                            <label for="province-1">Province/State <span class="text-danger">*</span>:</label>
                            <input name="vehicles[0][province]" type="text" id="province-1" class="form-control" required placeholder="Enter Province or State">
                        </div>
                        <div class="two-box form-row">
                            <div class="col-md-6 mb-3">
                                <label for="make-1">Make <span class="text-danger">*</span>:</label>
                                <input name="vehicles[0][make]" type="text" id="make-1" class="form-control" required placeholder="Enter Make">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model-1">Model <span class="text-danger">*</span>:</label>
                                <input name="vehicles[0][model]" type="text" id="model-1" class="form-control" required placeholder="Enter Model">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="year-1">Year <span class="text-danger">*</span>:</label>
                                <input name="vehicles[0][year]" type="text" id="year-1" class="form-control" required placeholder="Enter Year">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="color-1">Color <span class="text-danger">*</span>:</label>
                                <input name="vehicles[0][color]" type="text" id="color-1" class="form-control" required placeholder="Enter Color">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-name-1">Registered Owner's Name <span class="text-danger">*</span>:</label>
                            <input name="vehicles[0][registered_owner_name]" type="text" id="registered-owner-name-1" class="form-control" required placeholder="Enter Registered Owner's Name">
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-province-1">Province <span class="text-danger">*</span>:</label>
                            <select name="vehicles[0][registered_owner_province]" id="registered-owner-province-1" class="form-control" required>
                                <option value="">Select Province</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-municipality-1">Municipality <span class="text-danger">*</span>:</label>
                            <select name="vehicles[0][registered_owner_municipality]" id="registered-owner-municipality-1" class="form-control" required>
                                <option value="">Select Municipality</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-barangay-1">Barangay <span class="text-danger">*</span>:</label>
                            <select name="vehicles[0][registered_owner_barangay]" id="registered-owner-barangay-1" class="form-control" required>
                                <option value="">Select Barangay</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="registered-owner-zip-1">Postal/ZIP Code <span class="text-danger">*</span>:</label>
                            <input name="vehicles[0][registered_owner_zipcode]" type="text" id="registered-owner-zip-1" class="form-control" required placeholder="Enter ZIP Code">
                        </div>

                        <div class="upload-grid">
                            <div class="upload-group" data-label="OR-reg">
                                <input name="documents[0][file]" type="file" id="or-reg-1" class="form-control-file" accept=".jpg, .jpeg, .png" required>
                                <img id="or-reg-preview-1" class="img-preview or-preview" style="display:none;" alt="OR Preview">
                                <label for="or-reg-1">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload OR</span>
                                </label>
                            </div>

                            <div class="upload-group" data-label="CR-reg">
                                <input name="documents[1][file]" type="file" id="cr-reg-1" class="form-control-file" accept=".jpg, .jpeg, .png" required>
                                <img id="cr-reg-preview-1" class="img-preview cr-preview" style="display:none;" alt="CR Preview">
                                <label for="cr-reg-1">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload CR</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="documents[0][expiry_date]" class="form-label">Expiry Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="documents[0][expiry_date]" class="form-control" required>
                        </div>
                    </div>

                    <!-- Vehicle 2 Section (Hidden initially) -->
                    <div class="card shadow-sm mb-4 p-3 vehicle-section" id="vehicle-section-2" style="display:none;">
                        <h4>Vehicle Information (Vehicle 2)</h4>
                        <!-- Same fields for the second vehicle as Vehicle 1 -->
                        <div class="form-group">
                            <label for="license-plate-number-2">License Plate No. <span class="text-danger">*</span>:</label>
                            <input name="vehicles[1][license_plate]" type="text" id="license-plate-number-2" class="form-control" placeholder="Enter License Plate No.">
                        </div>
                        <div class="form-group">
                            <label for="province-2">Province/State <span class="text-danger">*</span>:</label>
                            <input name="vehicles[1][province]" type="text" id="province-2" class="form-control" placeholder="Enter Province or State">
                        </div>
                        <div class="two-box form-row">
                            <div class="col-md-6 mb-3">
                                <label for="make-2">Make <span class="text-danger">*</span>:</label>
                                <input name="vehicles[1][make]" type="text" id="make-2" class="form-control" placeholder="Enter Make">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model-2">Model <span class="text-danger">*</span>:</label>
                                <input name="vehicles[1][model]" type="text" id="model-2" class="form-control" placeholder="Enter Model">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="year-2">Year <span class="text-danger">*</span>:</label>
                                <input name="vehicles[1][year]" type="text" id="year-2" class="form-control" placeholder="Enter Year">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="color-2">Color <span class="text-danger">*</span>:</label>
                                <input name="vehicles[1][color]" type="text" id="color-2" class="form-control" placeholder="Enter Color">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-name-2">Registered Owner's Name <span class="text-danger">*</span>:</label>
                            <input name="vehicles[1][registered_owner_name]" type="text" id="registered-owner-name-2" class="form-control" required placeholder="Enter Registered Owner's Name">
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-province-2">Province <span class="text-danger">*</span>:</label>
                            <select name="vehicles[1][registered_owner_province]" id="registered-owner-province-2" class="form-control" required>
                                <option value="">Select Province</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-municipality-2">Municipality <span class="text-danger">*</span>:</label>
                            <select name="vehicles[1][registered_owner_municipality]" id="registered-owner-municipality-2" class="form-control" required>
                                <option value="">Select Municipality</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="registered-owner-barangay-2">Barangay <span class="text-danger">*</span>:</label>
                            <select name="vehicles[1][registered_owner_barangay]" id="registered-owner-barangay-2" class="form-control" required>
                                <option value="">Select Barangay</option>
                                <!-- Add options dynamically -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="registered-owner-zip-2">Postal/ZIP Code <span class="text-danger">*</span>:</label>
                            <input name="vehicles[1][registered_owner_zipcode]" type="text" id="registered-owner-zip-2" class="form-control" required placeholder="Enter ZIP Code">
                        </div>

                        <div class="upload-grid">
                            <div class="upload-group" data-label="OR-reg">
                                <input name="documents[2][file]" type="file" id="or-reg-2" accept=".jpg, .jpeg, .png" class="form-control-file">
                                <img id="or-reg-preview-2" class="img-preview or-preview" style="display:none;" alt="OR Preview">
                                <label for="or-reg-2">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload OR</span>
                                </label>
                            </div>
                            
                            <div class="upload-group" data-label="CR-reg">
                                <input name="documents[3][file]" type="file" id="cr-reg-2" accept=".jpg, .jpeg, .png" class="form-control-file">
                                <img id="cr-reg-preview-2" class="img-preview cr-preview" style="display:none;" alt="CR Preview">
                                <label for="cr-reg-2">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload CR</span>
                                </label>
                            </div>
                        </div>

                        <div class="class form-group">
                            <label for="documents[2][expiry_date]" class="form-label">Expiry Date <span class="text-danger">*</span>:</label>
                            <input type="date" name="documents[2][expiry_date]" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-danger remove-vehicle-btn" onclick="removeVehicle(2)">Remove Vehicle</button>
                    </div>
                </div>

                <div class="reg-footer text-center">
                    <button type="button" class="btn btn-secondary btn-add-vehicle" onclick="addVehicle()">Add Another Vehicle</button>
                    <button type="button" class="btn btn-primary btn-lg btn-submit" onclick="showConfirmationModal()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('incompleteProfileModal');
    const closeBtn = modal.querySelector('.close');
    const completeProfileBtn = document.getElementById('completeProfile');
    const remindMeLaterBtn = document.getElementById('remindMeLater');
    const registrationForm = document.getElementById('vehicle-registration-form');
    const formOverlay = document.createElement('div');

    // Disable the form and add an overlay to indicate it's disabled
    function disableForm() {
        registrationForm.style.pointerEvents = 'none';
       
        formOverlay.classList.add('form-overlay');
        registrationForm.appendChild(formOverlay);
    }

    // Create and style the overlay element
    formOverlay.style.position = 'absolute';
    formOverlay.style.top = '0';
    formOverlay.style.left = '0';
    formOverlay.style.width = '100%';
    formOverlay.style.height = '100%';
    formOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
    formOverlay.style.pointerEvents = 'none';

    // Initially disable the form
    disableForm();

    // "Complete Profile" button redirects to the profile page
    completeProfileBtn.addEventListener('click', function () {
        window.location.href = "{{ route('profile') }}";
    });

    // "Remind Me Later" button allows exploring the site but keeps the form disabled
    remindMeLaterBtn.addEventListener('click', function () {
        modal.style.display = 'none';
        alert("You can explore the site, but the Vehicle Registration form is disabled until you complete your profile.");
        disableForm(); // Ensure the form stays disabled
    });

    // Close modal button will have the same functionality as "Remind Me Later"
    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
        alert("Vehicle registration is disabled until you complete your profile.");
        disableForm(); // Ensure the form stays disabled
    });

    // Prevent closing the modal by clicking outside of it
    window.onclick = function (event) {
        if (event.target === modal) {
            alert('You must complete your profile to proceed with vehicle registration.');
        }
    };
});


</script>

<!-- Incomplete Profile Modal -->
@if(session('incomplete_profile') || isset($incomplete_profile) && $incomplete_profile)
    <div id="incompleteProfileModal" class="modal" style="display:block;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>Profile Incomplete</h4>
            <p>Your profile is incomplete. Please complete your profile by uploading your driver's license information before proceeding with vehicle registration.</p>
            <div class="modal-footer">
                <button id="completeProfile" class="btn btn-primary">Complete Profile</button>
                <button id="remindMeLater" class="btn btn-secondary">Remind Me Later</button>
            </div>
            
        </div>
    </div>
@endif

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h4>Confirm Submission</h4>
        <!-- Scrollable content container -->
        <div id="confirmation-modal-content" class="modal-scroll-content">
            <!-- The uploaded images and details will be inserted here by JavaScript -->
        </div>
        <button id="confirmSubmit" class="btn btn-success">Confirm</button>
    </div>
</div>

<!-- Warning Modal -->
<div id="warningModal" class="modal">
    <div class="modal-content" style="border-left: 5px solid orange;">
        <span class="close">&times;</span>
        <h4>Warning</h4>
        <div id="warning-list"></div>
    </div>
</div>

<!-- Modals -->
<div id="imagePreviewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" style="max-width: 100%; height: auto;">
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Terms and Conditions</h2>
        <p>Please read and agree to the terms and conditions before proceeding with the vehicle registration.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel sapien elit. In malesuada semper mi, nec bibendum ligula.</p>
        <div class="modal-footer">
            <button id="acceptTerms" class="btn btn-primary">I Agree</button>
            <button id="declineTerms" class="btn btn-secondary">Decline</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/vehicleRegistration.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<script src="{{ asset('js/uploadFile.js') }}"></script>


@endsection
