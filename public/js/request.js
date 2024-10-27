document.addEventListener('DOMContentLoaded', function() {
    // Function to update the ID label based on the user role
    function updateIDLabel(role) {
        let labelText;
        
        switch (role.toLowerCase()) {
            case 'student':
                labelText = 'Student ID';
                break;
            case 'faculty':
                labelText = 'Faculty ID';
                break;
            case 'parent':
                labelText = 'Parent ID';
                break;
            default:
                labelText = 'ID';
        }
        return labelText;
    }

    // Function to show or hide license plate based on vehicle type
    function toggleLicensePlate(vehicleType, licensePlateGroup) {
        if (vehicleType.toLowerCase() === 'electronic_vehicle') {
            licensePlateGroup.classList.add('d-none'); // Hide for electronic vehicles
        } else {
            licensePlateGroup.classList.remove('d-none'); // Show for fueled vehicles
        }
    }

    // Add event listeners for all modals
    const modals = document.querySelectorAll('.modal');

    modals.forEach((modal) => {
        modal.addEventListener('show.bs.modal', function () {
            // Update the ID label based on role
            const roleElement = modal.querySelector('.user-role');
            const idLabel = modal.querySelector('.id-label');

            if (roleElement && idLabel) {
                const role = roleElement.getAttribute('data-role');
                idLabel.textContent = updateIDLabel(role);
            }

            // Show or hide license plate based on vehicle type
            const vehicleTypeElement = modal.querySelector('.vehicle-type');
            const licensePlateGroup = modal.querySelector('.license-plate-group');
            
            if (vehicleTypeElement && licensePlateGroup) {
                const vehicleType = vehicleTypeElement.getAttribute('data-vehicle-type');
                toggleLicensePlate(vehicleType, licensePlateGroup);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Filter table rows based on selected role
    const roleFilter = document.getElementById('roleFilter');
    const tableRows = document.querySelectorAll('#request tbody tr');

    roleFilter.addEventListener('change', function() {
        const selectedRole = roleFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const rowRole = row.getAttribute('data-role');

            // Show all rows if 'all' is selected, otherwise show only matching rows
            if (selectedRole === 'all' || rowRole === selectedRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Enable/disable comment and update button based on status dropdown selection
    const statusDropdowns = document.querySelectorAll('.status-dropdown');

    statusDropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('change', function() {
            const selectedStatus = dropdown.value;
            const commentField = dropdown.closest('tr').querySelector('.comment-field');
            const updateButton = dropdown.closest('tr').querySelector('.update-btn');

            if (selectedStatus.toLowerCase() === 'pending') {
                commentField.disabled = true;
                updateButton.disabled = true;
            } else {
                commentField.disabled = false;
                updateButton.disabled = false;
            }
        });

        // Initial check based on the current status on page load
        dropdown.dispatchEvent(new Event('change'));
    });
});