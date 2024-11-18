@extends('layouts.securityLayout')

@section('title', 'Vehicle Logs')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<div class="header">
    <h1>Vehicle logs</h1>
    <div class="search-bar">
        <input type="date" id="date-picker">
    </div>
</div>

    <!-- vehicle logs table -->
    <div class="table-responsive">
        <table class="table table-bordered" id="usersTable">
            <thead>
                <tr>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Owner Name</th>
                    <th>Vehicle ID</th>
                    <th>Vehicle Type</th>
                    <th>User Type</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($approvedUsers as $user)
                    @foreach ($user->vehicles as $vehicle)
                        <tr class="vehicle-row" data-vehicle-type="{{ $vehicle->vehicle_type }}" data-user-type="{{ $user->type }}">
                            <td></td>
                            <td></td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->vehicle_type }}</td>
                            <td>{{ $user->type }}</td>
                            
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>


<!-- RFID Activation Modal -->
<div class="modal fade" id="rfidModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate RFID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="rfidActivationForm">
                    @csrf
                    <div class="form-group">
                        <label for="rfidTag">RFID Tag</label>
                        <input type="text" class="form-control" id="rfidTag" readonly>
                    </div>
                    <input type="hidden" id="vehicleId">
                    <button type="submit" class="btn btn-success">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
