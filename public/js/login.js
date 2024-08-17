const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

// Multi-step form logic with sliding transitions
const steps = document.querySelectorAll('.step');
let currentStep = 0;

function updateStep(step) {
    const offset = step * -100;
    steps.forEach((s, index) => {
        s.style.transform = `translateX(${offset}%)`;
    });
}
function updateStep(step) {
    steps.forEach((s, index) => {
        s.classList.remove('step-active');
        if (index === step) {
            s.classList.add('step-active');
        }
    });
}

document.querySelectorAll('.next-btn').forEach((btn, index) => {
    btn.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            updateStep(currentStep);
        }
    });
});

document.querySelectorAll('.prev-btn').forEach((btn, index) => {
    btn.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            updateStep(currentStep);
        }
    });
});

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

// Initialize the form with the first step visible
updateStep(currentStep);

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


