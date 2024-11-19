<!-- Sidebar -->
<nav class="sidebar">
    <!-- Logo container -->
    <div class="logo-container text-center my-3">
        <img src="{{ asset('Images/bsu_logo.png') }}" alt="Batangas State University Logo" class="logo">
    </div>

    <ul class="nav flex-column w-100">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a 
                href="{{ Auth::guard('admin')->user()->role === 'super_admin' ? route('super.admin.requests') : route('sub.admin.requests') }}" 
                class="nav-link {{ Request::routeIs('super.admin.requests', 'sub.admin.requests') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i>
                <span>Request</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.registries') }}" class="nav-link {{ Request::routeIs('admin.registries') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Registries</span>
            </a>
        </li>
        
        <!-- Dropdown for Settings -->
        <li class="nav-item">
            <a class="dropdown-btn">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
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




<!-- JavaScript dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/admin.js') }}"></script>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{ asset('css/adminStyles.css') }}">
