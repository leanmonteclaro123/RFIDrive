<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/security.css') }}">
</head>

<body>

    
    <!-- Sidebar -->
    <nav class="col-md-2 sidebar">
        <!-- Logo container -->
        <div class="logo-container">
            <img src="{{ asset('Images/bsu_logo.png') }}" alt="Batangas State University Logo" class="logo">
        </div>

        <ul class="nav flex-column w-100">
            <li class="nav-item">
                <a href="#dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#request">
                    <i class="fas fa-comment-dots"></i>
                    <span>Request</span>  
                </a>
            </li>
            <li class="nav-item">
                <a href="#registries">
                   <i class="fas fa-user"></i>
                   <span>Registries</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('security-logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
                <form id="security-logout-form" action="{{ route('security.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    
    <div class="main-content">
        <!-- Add IDs to content sections -->
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
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-registered">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-users"></i> Registered</div>
                            <div class="stat-number">{{ $registeredCount }}</div>
                        </div>
                    </div>
                </div>
                <!-- Pending Request Card -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-pending">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-clock"></i> Pending Request</div>
                            <div class="stat-number">{{ $pendingRequestCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="request" class="content-section" style="display: none;">
            <div class="header">
                <h1>Request</h1>
                <!-- Content for Request -->
            </div>
        </div>
    
        <div id="registries" class="content-section" style="display: none">
            <?php $requests = $requests ?? collect(); ?>
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
                                    <td>{{ is_array($request->vehicle_ids) ? count($request->vehicle_ids) : '0' }}</td>
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
        
        
        <div id="logout" class="content-section" style="display: none;">
            <div class="header">
                <h1>Log out</h1>
                <!-- Content for Log out -->
            </div>
        </div>
    </div>
    

    <!-- Include the security.js -->
    <script src="{{ asset('js/security.js') }}"></script>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
