@extends('adminLayout')

@section('title', 'Dashboard')

@section('content')
    <!-- Request Content -->
    @if($requests->isNotEmpty())
    <div id="request" class="table-container content-section" style="display:none;">
        <h2>Request Table</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->user->full_name }}</td>
                            <td>{{ $request->type }}</td>
                            <td>{{ ucfirst($request->status) }}</td>
                            <td>
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#requestDetailsModal{{ $request->id }}">
                                    <i class="fas fa-folder"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.requests.update', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <select name="status" class="form-control" required>
                                            <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                            <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="comments" class="form-control" placeholder="Comments (optional)">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @foreach($requests as $request)
    <!-- Modal: Registration Form View -->
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
                        <div class="two-box form-row">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <input type="text" class="form-control" readonly value="{{ $request->user->type }}">
                            </div>
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" readonly value="{{ $request->user->codeID ?? 'N/A' }}">
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
                        <div class="form-group" style="text-align:center">
                            <label>Expiry date : {{ $request->user->driver_license_expiry_date }}</label>
                        </div>
                    </div>

                    <!-- Vehicle Information Section -->
                    @php
                        $vehicleIds = json_decode($request->vehicle_ids, true);
                        $vehicles = \App\Models\Vehicle::whereIn('id', $vehicleIds)->with('documents')->get();
                    @endphp

                    @foreach($vehicles as $vehicleIndex => $vehicle)
                    <div class="card shadow-sm mb-4 p-3 vehicle-section">
                        <h4>Vehicle Information (Vehicle {{ $vehicleIndex + 1 }})</h4>
                        <div class="form-group">
                            <label>License Plate No.:</label>
                            <input type="text" class="form-control" readonly value="{{ $vehicle->license_plate }}">
                        </div>
                        <div class="form-group">
                            <label>Province/State:</label>
                            <input type="text" class="form-control" readonly value="{{ $vehicle->province }}">
                        </div>
                        <div class="two-box form-row">
                            <div class="form-group">
                                <label>Make:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->make }}">
                            </div>
                            <div class="form-group">
                                <label>Model:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->model }}">
                            </div>
                        </div>
                        <div class="two-box form-row">
                            <div class="form-group">
                                <label>Year:</label>
                                <input type="text" class="form-control" readonly value="{{ $vehicle->year }}">
                            </div>
                            <div class="form-group">
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
                        <div class="upload-grid">
                            @foreach($vehicle->documents as $document)
                                @if($document->type == 'OR' || $document->type == 'CR')
                                    <div class="upload-group">
                                        <img src="{{ asset('storage/' . $document->file_path) }}" class="img-preview" alt="{{ $document->type }} Preview" style="max-width: 200px;">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="form-group" style="text-align:center">
                            <label>Expiry Date: {{ $document->expiry_date }}</label>
                        </div>
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
