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
    <style>
        /* Base Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: 80px;
            background-color: #c0392b;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .sidebar:hover {
            width: 160px;
        }

        .sidebar img.logo {
            width: 70%;
            height: auto;
            transition: width 0.3s ease;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }

        .nav {
            width: 100%;
            padding: 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, padding 0.3s ease, color 0.3s ease;
            font-size: 14px;
            width: 100%;
        }

        .sidebar a span {
            display: none;
            margin-left: 8px;
        }

        .sidebar:hover a span {
            display: inline;
        }

        .sidebar:hover a {
            justify-content: flex-start;
            padding-left: 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .sidebar a i {
            font-size: 20px;
        }

        .nav-item {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Dropdown Custom Styles */
        .dropdown-menu {
            background-color: black;
            border: none;
        }

        .dropdown-menu .dropdown-item {
            color: white;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #555;
        }

        /* Adjusting Dropdown Arrow Position */
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: auto;
            vertical-align: middle;
            border: 0.3em solid transparent;
            border-top-color: white;
            content: "";
        }

        /* Hide dropdown caret when sidebar is minimized */
        .sidebar:hover .dropdown-toggle::after {
            display: inline-block;
        }

        .sidebar:not(:hover) .dropdown-toggle::after {
            display: none;
        }

        /* Main Content Styles */
        .content {
            width: calc(100% - 80px);
            padding: 20px;
            background-color: #fff;
            margin-left: 80px;
            height: 100vh;
            position: relative;
            transition: margin-left 0.3s ease, width 0.3s ease;
            overflow-y: auto;
            border-top-left-radius: 20px;
            /* Curved top left corner */
            border-bottom-left-radius: 20px;
            /* Curved bottom left corner */
        }

        .sidebar:hover~.content {
            margin-left: 160px;
            width: calc(100% - 160px);
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        /* Search Bar Styles */
        .search-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .search-bar input[type="text"] {
            width: 250px;
            padding: 8px;
            border-radius: 25px 0 0 25px;
            border: 1px solid #ccc;
            padding-left: 15px;
        }

        .search-bar button {
            padding: 8px 12px;
            border-radius: 0 25px 25px 0;
            border: none;
            background-color: transparent;
            color: #c0392b;
            cursor: pointer;
        }

        .search-bar .calendar-button {
            border-radius: 25px;
            background-color: transparent;
            border: 1px solid #ccc;
            border-left: none;
        }

        .search-bar input[type="date"] {
            margin-left: 15px;
            padding: 8px;
            border-radius: 25px;
            border: 1px solid #ccc;
        }

        .search-bar button:hover,
        .search-bar .calendar-button:hover {
            color: #a93226;
        }

        /* Card Styles */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            background-color: white;
            color: black;
            border: 1px solid #ddd;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000000;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            font-size: 24px;
            color: #c0392b;
        }

        /* Profile Section Styles */
        .profile-settings {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
        }

        .profile-settings .form-control {
            margin-bottom: 15px;
        }

        .profile-settings .avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .upload-reset-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Adjust the gap as needed */
        }

        .upload-reset-container .btn-secondary {
            margin-top: 0; /* Remove the margin-top from the Reset button */
        }


        /* Responsive Cards */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px;
                width: 100%;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar:hover~.content {
                margin-left: 160px;
                width: calc(100% - 160px);
            }

            .search-bar input[type="text"] {
                width: 100%;
            }
        }
    </style>
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
    <script>
        // Show and hide sections based on click
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }

        // Initially display the dashboard section
        showSection('dashboard');

        // Function to set active class on clicked navigation link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                showSection(this.getAttribute('onclick').match(/'([^']+)'/)[1]);
            });
        });

        // Set the date input to today's date
        document.getElementById('date-picker').valueAsDate = new Date();

        // Preview uploaded image
        function loadFile(event) {
            var avatarImage = document.getElementById('avatarImage');
            avatarImage.src = URL.createObjectURL(event.target.files[0]);
        }

        // Reset the form fields and profile picture
        document.getElementById('resetButton').addEventListener('click', function() {
            // Reset the form fields to their default values
            document.getElementById('profileForm').reset();
            
            // Reset the profile picture to its original source
            document.getElementById('avatarImage').src = "https://bootdey.com/img/Content/avatar/avatar1.png";
            
            // If needed, reset the file input
            document.querySelector('input[name="avatar"]').value = "";
        });
    </script>
</body>

</html>