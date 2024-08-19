@extends('layouts.app')

@section('title', 'Vehicle Registration Form')

@section('content')
<section class="home-content">
    <div class="container home-section" id="registration">
        <div class="card register-container shadow-lg p-4 mb-5 bg-white rounded">
            
            <div class="registration-header text-center">
                <h2>VEHICLE REGISTRATION FORM</h2>
                <p>Please complete all required fields </span></p>
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
                        <input type="file" id="dl-reg-front" class="form-control-file" accept=".jpg, .jpeg, .png" required>
                        <img id="dl-reg-preview-front" class="img-preview" style="display:none;" alt="Driver License Front Preview">
                        <label for="dl-reg-front">
                            <i class="fas fa-upload"></i>
                            <span>Driver License (Front)</span>
                        </label>
                    </div>
                    
                    <div class="upload-group" data-label="Driver_License-back">
                        <input type="file" id="dl-reg-back" class="form-control-file" accept=".jpg, .jpeg, .png" required>
                        <img id="dl-reg-preview-back" class="img-preview" style="display:none;" alt="Driver License Back Preview">
                        <label for="dl-reg-back">
                            <i class="fas fa-upload"></i>
                            <span>Driver License (Back)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="form-content" id="vehicle-sections">
                <!-- Initial Vehicle Information (Vehicle 1) -->
                <div class="card shadow-sm mb-4 p-3 vehicle-section" id="vehicle-section-1">
                    <h4>Vehicle Information (Vehicle 1)</h4>
                    <div class="form-group">
                        <label for="license-plate-number-1">License Plate No. <span class="text-danger">*</span>:</label>
                        <input type="text" id="license-plate-number-1" class="form-control" required placeholder="Enter License Plate No.">
                    </div>
                    <div class="form-group">
                        <label for="province-1">Province/State <span class="text-danger">*</span>:</label>
                        <input type="text" id="province-1" class="form-control" required placeholder="Enter Province or State">
                    </div>
                    <div class="two-box form-row">
                        <div class="col-md-6 mb-3">
                            <label for="make-1">Make <span class="text-danger">*</span>:</label>
                            <input type="text" id="make-1" class="form-control" required placeholder="Enter Make">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model-1">Model <span class="text-danger">*</span>:</label>
                            <input type="text" id="model-1" class="form-control" required placeholder="Enter Model">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="year-1">Year <span class="text-danger">*</span>:</label>
                            <input type="text" id="year-1" class="form-control" required placeholder="Enter Year">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="color-1">Color <span class="text-danger">*</span>:</label>
                            <input type="text" id="color-1" class="form-control" required placeholder="Enter Color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-name-1">Registered Owner's Name <span class="text-danger">*</span>:</label>
                        <input type="text" id="registered-owner-name-1" class="form-control" required placeholder="Enter Registered Owner's Name">
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-province-1">Province <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-province-1" class="form-control" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-municipality-1">Municipality <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-municipality-1" class="form-control" required>
                            <option value="">Select Municipality</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-barangay-1">Barangay <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-barangay-1" class="form-control" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="registered-owner-zip-1">Postal/ZIP Code <span class="text-danger">*</span>:</label>
                        <input type="text" id="registered-owner-zip-1" class="form-control" required placeholder="Enter ZIP Code">
                    </div>

                    <div class="upload-grid">
                        <div class="upload-group" data-label="OR-reg">
                            <input type="file" id="or-reg-1" class="form-control-file" accept=".jpg, .jpeg, .png" required >
                            <img id="or-reg-preview-1" class="img-preview or-preview" style="display:none;" alt="OR Preview">
                            <label for="or-reg-1">
                                <i class="fas fa-upload"></i>
                                <span>Upload OR</span>
                            </label>
                        </div>

                        <div class="upload-group" data-label="CR-reg">
                            <input type="file" id="cr-reg-1" class="form-control-file" accept=".jpg, .jpeg, .png" required>
                            <img id="cr-reg-preview-1" class="img-preview cr-preview" style="display:none;" alt="CR Preview">
                            <label for="cr-reg-1">
                                <i class="fas fa-upload"></i>
                                <span>Upload CR</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Placeholder for Vehicle 2, initially hidden -->
                <div class="card shadow-sm mb-4 p-3 vehicle-section" id="vehicle-section-2" style="display:none;">
                    <h4>Vehicle Information (Vehicle 2)</h4>
                    <!-- Same fields for the second vehicle as Vehicle 1 -->
                    <div class="form-group">
                        <label for="license-plate-number-2">License Plate No. <span class="text-danger">*</span>:</label>
                        <input type="text" id="license-plate-number-2" class="form-control" placeholder="Enter License Plate No.">
                    </div>
                    <div class="form-group">
                        <label for="province-2">Province/State <span class="text-danger">*</span>:</label>
                        <input type="text" id="province-2" class="form-control" placeholder="Enter Province or State">
                    </div>
                    <div class="two-box form-row">
                        <div class="col-md-6 mb-3">
                            <label for="make-2">Make <span class="text-danger">*</span>:</label>
                            <input type="text" id="make-2" class="form-control" placeholder="Enter Make">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model-2">Model <span class="text-danger">*</span>:</label>
                            <input type="text" id="model-2" class="form-control" placeholder="Enter Model">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="year-2">Year <span class="text-danger">*</span>:</label>
                            <input type="text" id="year-2" class="form-control" placeholder="Enter Year">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="color-2">Color <span class="text-danger">*</span>:</label>
                            <input type="text" id="color-2" class="form-control" placeholder="Enter Color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-name-2">Registered Owner's Name <span class="text-danger">*</span>:</label>
                        <input type="text" id="registered-owner-name-2" class="form-control" required placeholder="Enter Registered Owner's Name">
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-province-2">Province <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-province-2" class="form-control" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-municipality-2">Municipality <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-municipality-2" class="form-control" required>
                            <option value="">Select Municipality</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="registered-owner-barangay-2">Barangay <span class="text-danger">*</span>:</label>
                        <select id="registered-owner-barangay-2" class="form-control" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="registered-owner-zip-2">Postal/ZIP Code <span class="text-danger">*</span>:</label>
                        <input type="text" id="registered-owner-zip-2" class="form-control" required placeholder="Enter ZIP Code">
                    </div>

                    <div class="upload-grid">
                        <div class="upload-group" data-label="OR-reg">
                            <input type="file" id="or-reg-2" accept=".jpg, .jpeg, .png" class="form-control-file">
                            <img id="or-reg-preview-2" class="img-preview or-preview" style="display:none;" alt="OR Preview">
                            <label for="or-reg-2">
                                <i class="fas fa-upload"></i>
                                <span>Upload OR</span>
                            </label>
                        </div>
                        
                        <div class="upload-group" data-label="CR-reg">
                            <input type="file" id="cr-reg-2" accept=".jpg, .jpeg, .png" class="form-control-file">
                            <img id="cr-reg-preview-2" class="img-preview cr-preview" style="display:none;" alt="CR Preview">
                            <label for="cr-reg-2">
                                <i class="fas fa-upload"></i>
                                <span>Upload CR</span>
                            </label>
                        </div>
                        
                    </div>
                    <button type="button" class="btn btn-danger remove-vehicle-btn" onclick="removeVehicle(2)">Remove Vehicle</button>
                </div>
            </div>

            <div class="reg-footer text-center">
                <button type="button" class="btn btn-secondary btn-add-vehicle" onclick="addVehicle()">Add Another Vehicle</button>
                <button type="button" class="btn btn-primary btn-lg btn-submit" onclick="showConfirmationModal()">Submit</button>
            </div>
        </div>
    </div>
</section>
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

<link rel="stylesheet" href="{{ asset('css/vehicleRegistration.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<script src="{{ asset('js/uploadFile.js') }}"></script>
@endsection
