<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mega Able Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar">
                <!-- Logo container -->
                <div class="logo-container">
                    <img src="{{asset('Images/bsu_logo.png')}}" alt="Batangas State University Logo" class="logo">
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
                        <a href="#" class="nav-link dropdown-toggle" id="settingsDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
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
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
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

                <div id="request" class="table-container content-section" style="display:none;">
                    <h2>Request Table</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Request</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th> <!-- New Action Column -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Update Profile Picture</td>
                                    <td>Completed</td>
                                    <td>2024-08-15</td>
                                    <td>
                                        <button class="btn btn-success">Approve</button>
                                        <button class="btn btn-danger">Decline</button>
                                    </td> <!-- Action buttons -->
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Change Password</td>
                                    <td>Pending</td>
                                    <td>2024-08-14</td>
                                    <td>
                                        <button class="btn btn-success">Approve</button>
                                        <button class="btn btn-danger">Decline</button>
                                    </td> <!-- Action buttons -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="registries" class="table-container content-section" style="display:none;">
                    <h2>Registries Table</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th> <!-- New Action Column -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jane Doe</td>
                                    <td>jane.doe@example.com</td>
                                    <td>Admin</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td> <!-- Action buttons -->
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>John Smith</td>
                                    <td>john.smith@example.com</td>
                                    <td>User</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td> <!-- Action buttons -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

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

                <!-- Sales Analytics Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
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
</html>