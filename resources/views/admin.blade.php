<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('Images/bsu_logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
   
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar">
                <!-- Logo container -->
                <div class="logo-container">
                    <img src="{{ asset('Images/bsu_logo.png') }}" alt="Batangas State University Logo" class="logo">
                </div>

                <ul class="nav flex-column w-100">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" onclick="showSection('dashboard')">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('request')">
                            <i class="fas fa-comment-dots"></i>
                            <span>Request</span>  
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('registries')">
                           <i class="fas fa-user"></i>
                           <span>Registries</span>
                        </a>
                     </li>
                     
                    <li class="nav-item">
                        <a href="#" class="nav-link dropdown-toggle" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                            <li><a class="dropdown-item" href="#" onclick="showSection('profile')">Profile</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Logout</span>
                        </a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- DashBoard Content -->
            <div class="col-md-10 content">
                <div id="dashboard" class="content-section">
                    <div class="header">
                        <h1>Dashboard</h1>
                        <div class="search-bar">
                            <input type="text" placeholder="Search...">
                            <button><i class="fas fa-search"></i></button>
                            <input type="date" id="date-picker">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Registered Card -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="card card-registered">
                                <div class="card-body">
                                    <div class="card-title"><i class="fas fa-users"></i>Registered</div>
                                    <div class="stat-number"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Request Card -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="card card-pending">
                                <div class="card-body">
                                    <div class="card-title"><i class="fas fa-clock"></i>Pending Request</div>
                                    <div class="stat-number"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Approve Card -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="card card-approved">
                                <div class="card-body">
                                    <div class="card-title"><i class="fas fa-thumbs-up"></i>Approve</div>
                                    <div class="stat-number"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Disapprove Card -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="card card-disapproved">
                                <div class="card-body">
                                    <div class="card-title"><i class="fas fa-thumbs-down"></i>Disapprove</div>
                                    <div class="stat-number"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

                <!-- Registries Content -->
                <div id="registries" class="table-container content-section">
                    <h2>Registries Table</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Type</th>
                                    <th>Vehicles</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($requests->isNotEmpty())
                                    @foreach($requests as $request)
                                        <tr>
                                            <td>{{ $request->user->full_name }}</td>
                                            <td>{{ $request->user->type }}</td>
                                            <td>{{ $request->type }}</td>
                                            <td>{{ is_array(json_decode($request->vehicle_ids, true)) ? count(json_decode($request->vehicle_ids, true)) : '0' }}</td>
                                            <td>{{ ucfirst($request->status) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No registration requests found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- Profile Content -->
                <div id="profile" class="content-section profile-settings" style="display:none;">
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
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

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
</html>
