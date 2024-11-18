@extends('layouts.adminLayout')

@section('title', 'Request')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/requests.css') }}">
@endpush

@section('content')
<div id="request" class="table-container content-section">
    <h2>Request Table</h2>

    <!-- Filter Dropdown -->
    <div class="filter-section mb-3">
        <label for="roleFilter">Filter by Role:</label>
        <select id="roleFilter" class="form-control" style="width: auto; display: inline-block;">
            <option value="all">All</option>
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
            <option value="Parent">Parent</option>
            <option value="Tenant">Tenant</option>
        </select>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Registration Date</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr data-role="{{ strtolower($request->user->type) }}">
                        <td>{{ $request->created_at->format('m-d-Y') }}</td>
                        <td>{{ $request->user->full_name }}</td>
                        <td>{{ $request->user->type }}</td>
                        <td>{{ $request->type }}</td>
                        <td>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#requestDetailsModal{{ $request->id }}">
                                <i class="fas fa-folder"></i>
                            </button>
                        </td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>
                            <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="validated" class="btn btn-success">Validate</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                Reject
                            </button>
                        </td>
                    </tr>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $request->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel{{ $request->id }}">Reject Request</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.requests.update', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="comments">Reason for Rejection:</label>
                                            <textarea name="comments" id="comments" class="form-control" required></textarea>
                                        </div>
                                        <button type="submit" name="status" value="rejected" class="btn btn-danger mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <!-- Modals for Each Request -->
    @foreach($requests as $request)
    <div class="modal fade" id="requestDetailsModal{{$request->id }}" tabindex="-1" aria-labelledby="requestDetailsModalLabel{{$request->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestDetailsModalLabel{{ $request->id }}">Vehicle Registration Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="registration-header text-center">
                        <h2>VEHICLE REGISTRATION DETAILS</h2>
                        <p>Review the information submitted below.</p>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="card shadow-sm mb-4 p-3">
                        <h4>Personal Information</h4>
                        <div class="form-group">
                            <label for="full-name">Full Name:</label>
                            <input type="text" class="form-control" readonly value="{{ $request->user->full_name }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="role">Role:</label>
                                <input type="text" class="form-control user-role" readonly value="{{ $request->user->type }}" data-role="{{ $request->user->type }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id" class="id-label">ID:</label> <!-- Label to be updated -->
                                <input type="text" class="form-control user-id" readonly value="{{ $request->user->codeID ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone:</label>
                            <input type="text" class="form-control" readonly value="{{ $request->user->telephone }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" readonly value="{{ $request->user->barangay }}, {{ $request->user->municipal }}, {{ $request->user->province }}">
                        </div>
                        <div class="form-group">
                            <label for="campus">Campus:</label>
                            <input type="text" class="form-control" readonly value="{{ $request->user->campus }}">
                        </div>

                        <!-- Driver's License Details -->
                        <h5>Driver's License</h5>
                        <div class="upload-grid">
                            <div class="upload-group">
                                @if($request->user->driver_license_front)
                                    <img src="{{ asset($request->user->driver_license_front) }}" class="img-preview" alt="Driver License Front" style="max-width: 200px;">
                                    <label>Driver License (Front)</label>
                                @else
                                    <p>No Driver License (Front) uploaded.</p>
                                @endif
                            </div>
                            <div class="upload-group">
                                @if($request->user->driver_license_back)
                                    <img src="{{ asset($request->user->driver_license_back) }}" class="img-preview" alt="Driver License Back" style="max-width: 200px;">
                                    <label>Driver License (Back)</label>
                                @else
                                    <p>No Driver License (Back) uploaded.</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label>Expiry date: {{ $request->user->driver_license_expiry_date }}</label>
                        </div>
                    </div>

                    <!-- Vehicle Information Section -->
                    @php
                        $vehicleIds = json_decode($request->vehicle_ids, true);
                        $vehicles = \App\Models\Vehicle::whereIn('id', $vehicleIds)->with('documents')->get();
                    @endphp

                    @foreach($vehicles as $vehicle)
                    <div class="card shadow-sm mb-4 p-3 vehicle-section">
                        <h4>Vehicle Information</h4>
                        <div class="form-group" style="display: none">
                            <label>Vehicle Type:</label>
                            <input type="text" class="form-control vehicle-type" readonly value="{{ $vehicle->vehicle_type }}" data-vehicle-type="{{ $vehicle->vehicle_type }}">
                        </div>
            
                        <div class="form-group license-plate-group">
                            <label>License Plate No.:</label>
                            <input type="text" class="form-control license-plate" readonly value="{{ $vehicle->license_plate }}">
                        </div>
                        <div class="form-group">
                            <label>Province/State:</label>
                            <input type="text" class="form-control" readonly value="{{ $vehicle->province }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Make:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->make }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Model:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->model }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Year:</label>        
                                <input type="text" class="form-control" readonly value="{{ $vehicle->year }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Color:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->color }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Registered Owner's Name:</label>
                            <input type="text" class="form-control" readonly value="{{ $vehicle->registered_owner_name }}">
                        </div>
                        <div class="form-group">
                            <label>Owner's Address:</label>
                            <input type="text" class="form-control" readonly value="{{ $vehicle->registered_owner_barangay }}, {{ $vehicle->registered_owner_municipality }}, {{ $vehicle->registered_owner_province }}, {{ $vehicle->registered_owner_zipcode }}">
                        </div>

                        

                        <!-- Document Section -->
                        <h6>Documents</h6>
                        @foreach($vehicle->documents as $document)
                            @php
                                $isPdf = \Illuminate\Support\Str::endsWith($document->file_path, '.pdf');
                                $fileName = basename($document->file_path);
                                $expiryExcludedTypes = ['Certificate of Ownership', 'Certificate of Registration', 'Support Document'];
                            @endphp

                            <div class="upload-group" data-document-type="{{ $document->type }}">
                                @if($isPdf)
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                                        <img src="{{ asset('images/pdficon.jpg') }}" alt="PDF Icon" style="width: 100px; height: auto;">
                                        <p>{{ $fileName }}</p>
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $document->file_path) }}" class="img-preview" alt="{{ $document->type }} Preview" style="max-width: 200px;">
                                @endif
                                <label>{{ $document->type }}</label>

                                <!-- Expiry Date, Conditionally Rendered -->
                                @unless(in_array($document->type, $expiryExcludedTypes))
                                    <p class="expiry-date">Expiry Date: {{ $document->expiry_date }}</p>
                                @endunless
                            </div>
                        @endforeach

                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
@endsection

@push('scripts')
<script src="{{ asset('js/request.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
