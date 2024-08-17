@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="home-content">
    <!--=======HOME CONTENT =======-->
    <div class="container-fluid p-0 home-section fixed-bg" id="abt_us">
        <div id="aboutUsCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#aboutUsCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#aboutUsCarousel" data-slide-to="1"></li>
                <li data-target="#aboutUsCarousel" data-slide-to="2"></li>
                <li data-target="#aboutUsCarousel" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/coffee.jpg') }}" class="d-block w-100 home-img" alt="University Image 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/coffee.jpg') }}" class="d-block w-100 home-img" alt="University Image 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/coffee.jpg') }}" class="d-block w-100 home-img" alt="University Image 3">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/coffee.jpg') }}" class="d-block w-100 home-img" alt="University Image 4">
                </div>
            </div>
            <a class="carousel-control-prev" href="#aboutUsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#aboutUsCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="general-service-container">
            <h2 class="general-service-header">General Service Office</h2>
            <div class="general-service-content">
                <p>The General Services Office is the unit tasked to ensure a safe and clean environment for the University’s stakeholders. Its major task is to maintain the buildings, facilities, vehicles, and other equipment. Another task is the scheduling of the requests for the use of University facilities and vehicles. Additionally, the utility personnel of the Office are assigned to different offices of the University to maintain the cleanliness and orderliness of the buildings and facilities including the fixtures and sets of furniture.</p>
                <p>In terms of facility management, the repair and maintenance unit is positioned to maintain and properly take care of the facilities and other amenities of the institution. The Office has its Motor Pool Unit that is designed to facilitate all undertakings in relation to provision for transportation.</p>
                <p>One of the key units of the office is the Security Office. This unit is tasked to ensure the safety of lives of people and properties in the University. The traffic, parking, and security measures of the University are also facilitated and monitored by the Security Office under the supervision of the GSO Director.</p>
                </p>
            </div>
        </div>
    </div>

</section>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{asset('css/landing.css')}}">

@endsection
