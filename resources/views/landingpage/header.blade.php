<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<header class="header sticky-top">
    <nav class="nav container">
        <div class="nav__data">
            <a href="#" class="nav__logo">
                <img class="qw" src="/images/bsu_logo.png"> Batangas State University 
            </a>
            
            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-menu-line nav__burger"></i>
                <i class="ri-close-line nav__close"></i>
            </div>
        </div>

        <!--=============== NAV MENU ===============-->
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                {{-- <li><a href="#" class="nav__link" data-target="abt_us">Home</a></li> --}}
                <li><a href="{{ route('home') }}" class="nav__link {{ Request::routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('guidelines') }}" class="nav__link {{ Request::routeIs('guidelines') ? 'active' : '' }}">Guidelines</a></li>

                <!--=============== DROPDOWN 1 ===============-->
                @if(Auth::check())
                    <li class="dropdown__item" id="dropdown1">
                        <div class="nav__link" style="cursor: default">
                           Vehicle <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>

                        <ul class="dropdown__menu">
                            
                            <!--=============== DROPDOWN SUBMENU ===============-->
                            {{-- <li class="dropdown__subitem">
                                <div class="dropdown__link">
                                    <i  class="ri-bar-chart-line"></i>  Registration <i class="ri-add-line dropdown__add"></i>
                                    
                                </div>

                                <ul class="dropdown__submenu">
                                    <li>
                                        <a href="{{ route('vehicle.registration') }}" class="dropdown__link ">
                                            <i class="ri-pie-chart-line"></i>Fueled Vehicle
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('hybrid.vehicle.registration') }}" class="dropdown__link ">
                                            <i class="ri-pie-chart-line"></i>Electronic Vehicle
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            <!--=============== DROPDOWN ===============-->
                            <li>
                                <a href="{{ route('vehicle.registration') }}" class="dropdown__link ">
                                    <i class="ri-folder-user-line"></i>Registration
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown__link" data-target="renewal">
                                    <i class="ri-arrow-up-down-line"></i> Renewal
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif  

                @if(Auth::check())
                <!-- If user is logged in, show username and logout -->
                <li class="dropdown__item" id="dropdown2">
                    <div class="nav__link" style="cursor: default">
                        {{ Auth::user()->username }} <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                    </div>
                    <ul class="dropdown__menu">
                        <li><a href="{{ route('profile') }}" class="dropdown__link"><i class="ri-user-line"></i> Profile</a></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown__link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-lock-line"></i> LogOut
                            </a>
                        </li>
                    </ul>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <!-- If user is not logged in, show login button -->
                <li>
                    <a href="{{ route('login') }}" class="nav__link">
                        <i class="ri-lock-line"></i> Log In
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Terms and Conditions</h2>
            <p>Please read and agree to the terms and conditions before proceeding with the vehicle registration.</p>
            <p>
                <!-- You can add your terms and conditions text here -->
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel sapien elit. In malesuada semper mi, nec bibendum ligula.
            </p>
            <div class="modal-footer">
                <button id="acceptTerms" class="btn btn-primary">I Agree</button>
                <button id="declineTerms" class="btn btn-secondary">Decline</button>
            </div>
        </div>
    </div>

</header>
