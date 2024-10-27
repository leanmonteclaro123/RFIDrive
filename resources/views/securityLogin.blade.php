<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="{{ asset('images/bsu_logo.png') }}">
    <style>
        /* Custom CSS */
        body {
            background: linear-gradient(135deg, white gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .admin-login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .admin-login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-login-header img {
            max-width: 80px;
            margin-bottom: 15px;
        }

        .admin-login-header h1 {
            font-size: 26px;
            color: #e74c3c;
            margin-top: 0;
        }

        .login-form .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .login-form .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }

        .login-form .form-control {
            padding-left: 35px;
            height: 45px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            background-color: #e74c3c;
            border: none;
            color: white;
            transition: background 0.3s ease;
        }

        .login-form button:hover {
            background-color: #c0392b;
        }

        .login-form .forgot-password {
            text-align: right;
            font-size: 14px;
            margin-top: 10px;
        }

        .login-form .forgot-password a {
            color: #e74c3c;
        }

        .login-form .forgot-password a:hover {
            color: #c0392b;
        }

        .login-form .social-login {
            text-align: center;
            margin-top: 20px;
        }

        .social-login i {
            margin: 0 10px;
            color: #e74c3c;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .social-login i:hover {
            color: #c0392b;
        }

    </style>
</head>
<body>

<div class="admin-login-container">
    <div class="admin-login-header">
        <img src="{{asset('Images/bsu_logo.png')}}" alt="BSU Logo">
        <h1>Hello, Security!</h1>
        <p>Enter your credentials to access the admin dashboard</p>
    </div>
    
    <div class="login-form">
        
        <form action="{{ route('security.login.post') }}" method="POST">
            @csrf <!-- Include CSRF token for security if you're using Laravel -->
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <label for="email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <label for="password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="forgot-password">
                <a href="your-password-reset-url">Forgot your password?</a>
            </div>
            <button type="submit" class="btn btn-danger">Sign In</button>
        </form>
    </div>
</div>

</body>
</html>
