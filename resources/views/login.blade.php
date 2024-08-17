<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('Images/bsu_logo.png') }}">
    <title>Login</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href={{asset('css/login.css')}}>
</head>
<body>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form id="signUpForm" method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registration</span>

            <div class="step-container">
                <!-- Step 1: Personal Details -->
                <div class="step">
                    <input name="role" type="hidden" value="User">
                    <input name="full_name" type="text" placeholder="Full name" required/>
                    <input name="telephone" type="text" placeholder="Telephone" maxlength="11" title="Maximum of 11 numbers" required />
                    <div class="button-container">
                        <button type="button" class="prev-btn" style="visibility:hidden;">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>

                <!-- Step 2: Account Details -->
                <div class="step">
                    <select name="province" required>
                        <option value="">Select Province</option>
                    </select>
                    
                    <!-- The municipal list will be populated dynamically via JavaScript -->
                    <select name="municipal" required>
                        <option value="">Select Municipal</option>
                    </select>
                    
                    <select name="barangay" required>
                        <option>Select Barangay</option>
                    </select>
                    
                    <input type="text" name="zipcode" placeholder="Postal Code" readonly />
                    <div class="button-container">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>
                
                
                <!-- Step 3: Account Details -->
                <div class="step">
                    <select name="type" required>
                        <option>Select Role</option>
                        <option value="Student">Student</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Parent">Parent</option>
                        <option value="Tenants">Tenants</option>
                    </select>
                    <input name="codeID" type="text" placeholder="ID" />
                    <input name="campus" type="hidden" value="Batangas State University ARASOF Nasugbu">
                    <div class="button-container">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>

                <!-- Step 4: Account Details -->
                <div class="step">
                    <input name="username" type="text" placeholder="Username" required/>
                    <input type="email" name="email" placeholder="Email" required/>
                    <input type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
                    <input type="password"  name="password_confirmation" placeholder="Confirm Password" required/>
                    <div class="button-container">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>
                </div>

                <!-- Step 5: Confirmation -->
                <div class="step">
                    <p>Review your details and submit</p>
                    <p>Make sure your information is correct before clicking the submit</p>
                    <div class="button-container">
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="submit" class="next-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <h1>Sign in</h1>
    
            <!-- Error Display -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
    
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your account</span>
            
            <!-- Sign In -->
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="#">Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>
    

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <img src="{{asset('Images/redspartan.png')}}" alt="ewan">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <img class="logo" src="{{asset('Images/bsu_logo.png')}}" alt="ewan">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<script src={{ asset('js/login.js') }}></script>
</body>
</html>
