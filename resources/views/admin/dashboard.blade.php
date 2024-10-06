@extends('layouts.adminLayout')

@section('title', 'Dashboard')

@section('content')
    
    <!-- DashBoard Content -->
    <div class="col-md-10 content">
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
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card card-registered">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-users"></i>Registered</div>
                            <div class="stat-number"></div>
                        </div>
                    </div>
                </div>
                <!-- Pending Request Card -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card card-pending">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-clock"></i>Pending Request</div>
                            <div class="stat-number"></div>
                        </div>
                    </div>
                </div>
                <!-- Approve Card -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card card-approved">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-thumbs-up"></i>Approve</div>
                            <div class="stat-number"></div>
                        </div>
                    </div>
                </div>
                <!-- Disapprove Card -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card card-disapproved">
                        <div class="card-body">
                            <div class="card-title"><i class="fas fa-thumbs-down"></i>Disapprove</div>
                            <div class="stat-number"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
