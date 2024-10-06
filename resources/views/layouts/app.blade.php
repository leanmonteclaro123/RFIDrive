<!DOCTYPE html>
<html lang="en">
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== Bootstrap CSS ===============-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <link rel="icon" href="{{ asset('images/bsu_logo.png') }}">
    
    <title>@yield('title', 'Default Title')</title>
</head>
<body>
    <!--=============== HEADER ===============-->
    @include('landingpage.header')

    <!--=============== MAIN CONTENT ===============-->
    <div class="main-content">
        @yield('content')
    </div>

    <!--=============== FOOTER ===============-->
    @include('landingpage.footer')

    <!--=============== MAIN JS ===============-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{asset('js/header.js')}}"></script>
</body>
</html>
