// Success modal popup functionality
const successModal = document.getElementById('successModal');
const goToLoginBtn = document.getElementById('goToLogin');

// Function to open the modal (using class "show" for visibility and opacity)
function showSuccessModal() {
    successModal.classList.add('show'); // Add "show" class to make the modal visible
}

// Function to hide the modal and redirect to login
goToLoginBtn.addEventListener('click', function () {
    successModal.classList.remove('show'); // Hide the modal
    window.location.href = '/login'; // Redirect to login page
});

// Handle form submission and show the success modal
document.getElementById('signUpForm').addEventListener('submit', function (event) {
    // Check if the current step is the last one and form is valid
    if (currentStep === steps.length - 1 && validateStep(currentStep)) {
        event.preventDefault(); // Prevent immediate form submission
        showSuccessModal(); // Show the success modal

        // After showing the modal, submit the form
        goToLoginBtn.addEventListener('click', () => {
            this.submit(); // Submit the form after clicking "OK"
        });
    } else {
        event.preventDefault(); // Prevent form submission until validation is complete
        validateStep(currentStep); // Validate current step if not the final step
    }
});


const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

// Toggle between Sign Up and Sign In
signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

const steps = document.querySelectorAll('.step');
let currentStep = 0;

// Function to validate the current step inputs and selects
function validateStep(step) {
    let isValid = true; // Assume the form is valid initially
    const inputs = steps[step].querySelectorAll('input, select'); // Get all inputs and selects in the current step

    // Clear any previous error messages
    steps[step].querySelectorAll('.error-message').forEach(errorMsg => {
        errorMsg.textContent = ''; // Clear previous error messages
    });

    // Validate each input or select field
    inputs.forEach(input => {
        const errorMessage = input.nextElementSibling; // Get the span element right after the input

        // Check if the field is empty (for both input and select elements)
        if (!input.value || input.value === '') {
            isValid = false; // Form is invalid
            errorMessage.textContent = input.placeholder || 'This field is required.'; // Set error message
        } else {
            // Specific validation for telephone (must be exactly 11 digits)
            if (input.name === 'telephone' && input.value.length !== 11) {
                isValid = false; // Form is invalid
                errorMessage.textContent = 'Telephone must be exactly 11 digits.';
            }

            // Specific validation for email (check for the @ symbol)
            if (input.name === 'email' && !validateEmail(input.value)) {
                isValid = false; // Form is invalid
                errorMessage.textContent = 'Please enter a valid email address.';
            }

            // Specific validation for password (custom pattern)
            if (input.name === 'password' && !input.checkValidity()) {
                isValid = false; // Form is invalid
                errorMessage.textContent = input.title; // Use the title attribute for the error message
            }

            // Specific validation for password confirmation (must match password)
            if (input.name === 'password_confirmation') {
                const passwordInput = steps[step].querySelector('input[name="password"]');
                if (input.value !== passwordInput.value) {
                    isValid = false; // Form is invalid
                    errorMessage.textContent = 'Passwords do not match.';
                }
            }
        }
    });

    return isValid;
}

// Function to validate email format (using regex)
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Function to update the step of the form
function updateStep(step) {
    steps.forEach((s, index) => {
        s.classList.remove('step-active');
        if (index === step) {
            s.classList.add('step-active');
        }
    });
}

// Event listener for the Next buttons
document.querySelectorAll('.next-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (validateStep(currentStep)) { // Validate current step
            if (currentStep < steps.length - 1) {
                currentStep++;
                updateStep(currentStep); // Move to the next step if valid
            }
        }
    });
});

// Event listener for the Previous buttons
document.querySelectorAll('.prev-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            updateStep(currentStep); // Go back to the previous step
        }
    });
});

// Initialize the form with the first step visible
updateStep(currentStep);

// Role-specific ID input update
document.addEventListener('DOMContentLoaded', function () {
    const roleDropdown = document.querySelector('select[name="type"]');
    const idInput = document.querySelector('input[name="codeID"]');

    roleDropdown.addEventListener('change', function () {
        const selectedRole = this.value;

        switch (selectedRole) {
            case 'Faculty':
                idInput.placeholder = 'Faculty ID';
                idInput.required = true;
                break;
            case 'Student':
                idInput.placeholder = 'SrCode';
                idInput.required = true;
                break;
            case 'Parent':
                idInput.placeholder = 'Parent ID';
                idInput.required = false;
                break;
            case 'Tenants':
                idInput.placeholder = 'Tenant ID';
                idInput.required = false;
                break;
            default:
                idInput.placeholder = 'ID'; // Default placeholder
                idInput.required = false;
                break;
        }
    });
});

// Province, Municipal, Barangay Fetch Logic
document.addEventListener('DOMContentLoaded', function () {
    const provinceDropdown = document.querySelector('select[name="province"]');
    const municipalDropdown = document.querySelector('select[name="municipal"]');
    const barangayDropdown = document.querySelector('select[name="barangay"]');
    const zipCodeInput = document.querySelector('input[name="zipcode"]');

    // Fetch provinces and populate the province dropdown
    function fetchProvinces() {
        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                data.forEach(province => {
                    let option = document.createElement('option');
                    option.value = province.name; // Store the province name
                    option.textContent = province.name; // Display the province name
                    option.dataset.provinceCode = province.code; // Store the province code in a data attribute
                    provinceDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching provinces:', error);
            });
    }

    // Fetch municipalities based on the selected province name
    function fetchMunicipalities(provinceCode) {
        fetch(`/municipalities/${provinceCode}`)
            .then(response => response.json())
            .then(data => {
                municipalDropdown.innerHTML = '<option value="">Select Municipal</option>'; // Reset municipalities
                data.forEach(municipality => {
                    let option = document.createElement('option');
                    option.value = municipality.name; // Store the municipal name
                    option.textContent = municipality.name; // Display the municipal name
                    option.dataset.municipalCode = municipality.code; // Store the municipal code in a data attribute
                    municipalDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching municipalities:', error);
            });
    }

    // Fetch barangays based on the selected municipality code
    function fetchBarangays(municipalityCode) {
        fetch(`/barangays/${municipalityCode}`)
            .then(response => response.json())
            .then(data => {
                barangayDropdown.innerHTML = '<option>Select Barangay</option>'; // Reset barangays
                data.forEach(barangay => {
                    let option = document.createElement('option');
                    option.value = barangay.name; // Use the barangay name for storage
                    option.textContent = barangay.name; // Display the barangay name
                    barangayDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching barangays:', error);
            });
    }

    // Fetch zip code based on the selected municipality name
    function fetchZipCode(municipalityName) {
        const encodedMunicipality = encodeURIComponent(municipalityName);
    
        fetch(`/zipcode?municipality=${encodedMunicipality}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);
                if (data.zipcode) {
                    zipCodeInput.value = data.zipcode;
                } else {
                    zipCodeInput.value = 'No Zip Code Found';
                }
            })
            .catch(error => {
                console.error('Error fetching zip code:', error);
                zipCodeInput.value = 'Error fetching zip code';
            });
    }

    // Event listener for province change to fetch municipalities
    provinceDropdown.addEventListener('change', function () {
        const selectedProvinceCode = this.options[this.selectedIndex].dataset.provinceCode; // Get province code
        console.log('Fetching municipalities for province code:', selectedProvinceCode);
        fetchMunicipalities(selectedProvinceCode); // Pass province code
    });

    // Event listener for municipality change to fetch barangays and zip code
    municipalDropdown.addEventListener('change', function () {
        const selectedMunicipalCode = this.options[this.selectedIndex].dataset.municipalCode; // Get municipal code
        console.log('Fetching barangays for municipal code:', selectedMunicipalCode);
        fetchBarangays(selectedMunicipalCode); // Fetch barangays

        const selectedMunicipalName = municipalDropdown.options[municipalDropdown.selectedIndex].text; // Get the name
        console.log('Fetching zip code for municipality name:', selectedMunicipalName);
        fetchZipCode(selectedMunicipalName); // Fetch zip code based on name
    });

    // Initial fetch for provinces on page load
    fetchProvinces();
});

document.addEventListener('DOMContentLoaded', function () {
    const roleDropdown = document.querySelector('select[name="type"]');
    const idInput = document.querySelector('input[name="codeID"]');

    roleDropdown.addEventListener('change', function () {
        const selectedRole = this.value;

        if (selectedRole === 'Student' || selectedRole === 'Faculty') {
            idInput.removeAttribute('readonly');
            idInput.value = '';  // Clear the input field when editable
            idInput.placeholder = selectedRole === 'Student' ? 'SrCode' : 'Faculty ID';
            idInput.required = true;
        } else if (selectedRole === '') {  // Handle the "Select Role" case
            idInput.setAttribute('readonly', true);
            idInput.value = '';  // Set value to blank when "Select Role" is selected
            idInput.placeholder = 'ID';
            idInput.required = false;
        } else {
            idInput.setAttribute('readonly', true);
            idInput.value = 'N/A';  // Set value to N/A for other roles
            idInput.placeholder = 'ID';
            idInput.required = false;
        }
    });
});


