@extends('layouts.securityLayout')

@section('title', 'RFID Activation')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">RFID Activation</h2>

    <!-- Search bar and filters for filtering users and vehicles -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name or vehicle plate">
        </div>
        <div class="col-md-3">
            <select id="vehicleTypeFilter" class="form-control">
                <option value="">All Vehicle Types</option>
                <option value="fueled_vehicle">Fueled Vehicle</option>
                <option value="electric_vehicle">Electric Vehicle</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="userTypeFilter" class="form-control">
                <option value="">All User Types</option>
                <option value="Student">Student</option>
                <option value="Faculty">Faculty</option>
                <option value="Staff">Staff</option>
            </select>
        </div>
    </div>

    <!-- Users and vehicles table -->
    <div class="table-responsive">
        <table class="table table-bordered" id="usersTable">
            <thead>
                <tr>
                    <th>Owner Name</th>
                    <th>Vehicle ID</th>
                    <th>Vehicle Type</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($approvedUsers as $user)
                    @foreach ($user->vehicles as $vehicle)
                        <tr class="vehicle-row" data-vehicle-type="{{ $vehicle->vehicle_type }}" data-user-type="{{ $user->type }}">
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->vehicle_type }}</td>
                            <td>{{ $user->type }}</td>
                            <td>
                                <button class="btn btn-primary activate-btn" data-vehicle-id="{{ $vehicle->id }}">
                                    Activate RFID
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
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
                <form id="rfidForm">
                    <div class="form-group">
                        <label for="rfidtag">RFID Tag</label>
                        <input type="text" class="form-control" id="rfidtag" name="rfid_tag" readonly>
                    </div>
                    <button type="button" class="btn btn-primary" id="activateRfidButton">Activate</button>
                </form>
            </div>            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search and filter functionality
document.getElementById('searchInput').addEventListener('keyup', filterTable);
document.getElementById('vehicleTypeFilter').addEventListener('change', filterTable);
document.getElementById('userTypeFilter').addEventListener('change', filterTable);

function filterTable() {
    const filterText = document.getElementById('searchInput').value.toLowerCase();
    const vehicleType = document.getElementById('vehicleTypeFilter').value.toLowerCase();
    const userType = document.getElementById('userTypeFilter').value.toLowerCase();

    const rows = document.querySelectorAll('#usersTable tbody tr.vehicle-row');

    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const plate = row.cells[2].textContent.toLowerCase();
        const rowVehicleType = row.getAttribute('data-vehicle-type').toLowerCase();
        const rowUserType = row.getAttribute('data-user-type').toLowerCase();

        const matchesText = name.includes(filterText) || plate.includes(filterText);
        const matchesVehicleType = vehicleType === '' || vehicleType === rowVehicleType;
        const matchesUserType = userType === '' || userType === rowUserType;

        row.style.display = matchesText && matchesVehicleType && matchesUserType ? '' : 'none';
    });
}

// Activate RFID button click event
document.querySelectorAll('.activate-btn').forEach(button => {
    button.addEventListener('click', function() {
        const vehicleId = this.getAttribute('data-vehicle-id');
        document.getElementById('vehicleId').value = vehicleId;
        $('#rfidModal').modal('show');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const rfidInput = document.getElementById("rfidtag");

    // Example using WebSocket (you can replace this with Fetch API if needed)
    const socket = new WebSocket("ws://your-nodemcu-ip:your-port");
    socket.onmessage = function(event) {
        const rfidTag = event.data;
        rfidInput.value = rfidTag;  // Automatically fill the RFID input field
    };

    document.getElementById("activateRfidButton").addEventListener("click", function() {
        const rfidTag = rfidInput.value;
        if (rfidTag) {
            const form = document.getElementById("rfidForm");
            form.submit();  // Submit the form to store RFID tag
        } else {
            alert("No RFID tag detected");
        }
    });
});


</script>
@endpush
