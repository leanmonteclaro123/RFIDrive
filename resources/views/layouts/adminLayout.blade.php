<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('Images/bsu_logo.png') }}" type="image/x-icon">
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
                        <a href="{{ route('admin.dashboard') }}" >
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.requests') }}">
                            <i class="fas fa-comment-dots"></i>
                            <span>Request</span>  
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.registries') }}">
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
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Logout</span>
                        </a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    
                </ul>
            </nav>

            <!-- Content Section -->
            <div class="col-md-10 content">
                @yield('content') <!-- Dynamically load content -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
    
</body>

</html>
