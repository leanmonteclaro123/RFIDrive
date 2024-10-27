@extends('layouts.securityLayout')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="header">
    <h1>Dashboard</h1>
    <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button><i class="fas fa-search"></i></button>
        <input type="date" id="date-picker">
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-registered">
            <div class="card-body">
                <div class="card-title"><i class="fas fa-users"></i> Registered</div>
                <div class="stat-number">{{ $registeredCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-pending">
            <div class="card-body">
                <div class="card-title"><i class="fas fa-clock"></i> Pending Request</div>
                <div class="stat-number">{{ $pendingRequestCount }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
