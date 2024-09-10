<!-- adminLayout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="container-fluid">
        @include('admin.sidebar') <!-- Navigation bar -->

        <div class="content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
