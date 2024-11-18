@extends('layouts.adminLayout')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    
    <!-- Dashboard Content -->
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
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card card-registered">
                    <div class="card-body">
                        <div class="card-title"><i class="fas fa-users"></i> Registered</div>
                        <div class="stat-number">{{ $registeredCount }}</div>
                    </div>
                </div>
            </div>
            <!-- Pending Request Card -->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card card-pending">
                    <div class="card-body">
                        <div class="card-title"><i class="fas fa-clock"></i> Pending Request</div>
                        <div class="stat-number">{{ $pendingRequestCount }}</div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart Section -->
            {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><i class="fas fa-chart-pie"></i> Registration Status</div>
                        <canvas id="registrationStatusChart"></canvas>
                    </div>
                </div>
            </div>
            <br> --}}

            <!-- Request History Chart Section -->
            {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><i class="fas fa-chart-line"></i> Request History (Last 30 Days)</div>
                        <canvas id="requestHistoryChart"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pie chart for registration status
        const ctxStatus = document.getElementById('registrationStatusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: ['Registered', 'Pending'],
                datasets: [{
                    label: 'Registration Status',
                    data: [{{ $registeredCount }}, {{ $pendingRequestCount }}],
                    backgroundColor: ['#4CAF50', '#FF9800'],
                    borderColor: ['#4CAF50', '#FF9800'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Line chart for request history
        
    });
</script> --}}
@endpush


@endsection
