<!-- Sidebar -->
<nav class="sidebar">
    <!-- Logo container -->
    <div class="logo-container text-center my-3">
        <img src="{{ asset('Images/bsu_logo.png') }}" alt="Batangas State University Logo" class="logo">
    </div>

    <ul class="nav flex-column w-100">
        <li class="nav-item">
            <a href="{{ route('security.dashboard') }}" class="nav-link {{ Request::routeIs('security.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('security.registries') }}" class="nav-link {{ Request::routeIs('security.registries') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Registries</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('security.rfid.form') }}" class="nav-link {{ Request::routeIs('security.rfid.form') ? 'active' : '' }}">
                <i class="fa-solid fa-address-card"></i>
                <span>RFID Activation</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('security.vehicle.form') }}" class="nav-link {{ Request::routeIs('security.vehicle.form') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i>
                <span>Vehicle Logs</span>
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

<!-- JavaScript dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{ asset('css/adminStyles.css') }}">
