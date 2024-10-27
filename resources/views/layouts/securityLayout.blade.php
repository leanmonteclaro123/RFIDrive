<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/bsu_logo.png') }}">

    <title>@yield('title', 'Default Title')</title>

    <!-- other links and meta -->
    @stack('styles')
</head>
<body>
    <!-- Sidebar and Main Content Wrapper -->
    <div class="d-flex">
        <!-- Sidebar -->
        @include('securitySideBar') 
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- JavaScript dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
