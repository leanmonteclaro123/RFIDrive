document.addEventListener('DOMContentLoaded', function () {
    let vehicleCount = 1; // Track the number of vehicles (1 by default)

    // Function to change the ID label based on the user's type (role)
    function updateIDLabel() {
        const role = document.getElementById('role').value;
        const idLabel = document.querySelector('label[for="id"]');

        if (role === 'Student') {
            idLabel.innerHTML = 'Student ID <span class="text-danger">*</span>:';
        } else if (role === 'Faculty') {
            idLabel.innerHTML = 'Employee ID <span class="text-danger">*</span>:';
        }else if (role === 'Parent') {
            idLabel.innerHTML = 'Parent ID <span class="text-danger">*</span>:';
        }else if (role === 'Tenant') {
            idLabel.innerHTML = 'Tenant ID <span class="text-danger">*</span>:';
        } else {
            idLabel.innerHTML = 'ID <span class="text-danger">*</span>:';
        }
    }

    // Call updateIDLabel on page load
    updateIDLabel();

    // Function to populate dropdowns for provinces, municipalities, barangays for any vehicle section
    function loadProvinces(vehicleNumber) {
        const provinceSelect = document.getElementById(`registered-owner-province-${vehicleNumber}`);
        const municipalitySelect = document.getElementById(`registered-owner-municipality-${vehicleNumber}`);
        const barangaySelect = document.getElementById(`registered-owner-barangay-${vehicleNumber}`);
        const zipCodeInput = document.getElementById(`registered-owner-zip-${vehicleNumber}`);

        // Reset municipality and barangay dropdowns when province changes
        provinceSelect.addEventListener('change', function () {
            const provinceCode = this.value;
            if (provinceCode) {
                fetch(`/municipalities/${provinceCode}`)
                    .then(response => response.json())
                    .then(data => {
                        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>'; // Reset barangays
                        data.forEach(municipality => {
                            const option = document.createElement('option');
                            option.value = municipality.code;
                            option.text = municipality.name;
                            municipalitySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching municipalities:', error));
            }
        });

        // Load barangays when a municipality is selected and fill in the zip code
        municipalitySelect.addEventListener('change', function () {
            const municipalityCode = this.value;
            if (municipalityCode) {
                fetch(`/barangays/${municipalityCode}`)
                    .then(response => response.json())
                    .then(data => {
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                        data.forEach(barangay => {
                            const option = document.createElement('option');
                            option.value = barangay.code;
                            option.text = barangay.name;
                            barangaySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching barangays:', error));

                // Fetch zip code based on the selected municipality
                const selectedMunicipality = municipalitySelect.options[municipalitySelect.selectedIndex].text;
                fetch(`/zipcode?municipality=${selectedMunicipality}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.zipcode) {
                            zipCodeInput.value = data.zipcode;
                        } else {
                            zipCodeInput.value = '';
                            console.error('No zip code found for the selected municipality');
                        }
                    })
                    .catch(error => {
                        zipCodeInput.value = '';
                        console.error('Error fetching zip code:', error);
                    });
            }
        });

        // Load provinces on page load
        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.code;
                    option.text = province.name;
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));
    }

    // Load provinces and other dropdowns for the first vehicle initially
    loadProvinces(1);

    // Add vehicle functionality
    window.addVehicle = function () {
        if (vehicleCount < 2) {
            const vehicleSection2 = document.getElementById('vehicle-section-2');
            if (vehicleSection2) {
                vehicleSection2.style.display = 'block';
                console.log('Vehicle 2 section displayed');
                loadProvinces(2); // Initialize provinces and dropdowns for the second vehicle
            }
            vehicleCount++;

            // Disable "Add Another Vehicle" button
            const addVehicleBtn = document.querySelector('.btn-add-vehicle');
            if (addVehicleBtn) {
                addVehicleBtn.disabled = true;
                addVehicleBtn.innerText = 'Maximum of 2 Vehicles Reached';
            }

            // Initialize file preview handling for Vehicle 2
            initFilePreviews(2);
        }
    };

    // Remove vehicle functionality
    window.removeVehicle = function (vehicleNumber) {
        if (vehicleNumber === 2) {
            const vehicleSection2 = document.getElementById('vehicle-section-2');
            if (vehicleSection2) {
                vehicleSection2.style.display = 'none';
                console.log('Vehicle 2 section hidden');

                // Clear the state for the files of Vehicle 2
                state.lastOrFile2 = null;
                state.lastCrFile2 = null;
            }
            vehicleCount--;

            // Re-enable "Add Another Vehicle" button
            const addVehicleBtn = document.querySelector('.btn-add-vehicle');
            if (addVehicleBtn) {
                addVehicleBtn.disabled = false;
                addVehicleBtn.innerText = 'Add Another Vehicle';
            }

            // Clear the second vehicle's inputs
            clearVehicleSection(2);
        }
    };

    // Clear vehicle section inputs and file previews
    function clearVehicleSection(vehicleNumber) {
        console.log(`Clearing inputs for vehicle ${vehicleNumber}`);
        
        // Clear form fields
        document.getElementById(`license-plate-number-${vehicleNumber}`).value = '';
        document.getElementById(`registered-owner-province-${vehicleNumber}`).value = '';
        document.getElementById(`registered-owner-municipality-${vehicleNumber}`).innerHTML = '<option value="">Select Municipality</option>';
        document.getElementById(`registered-owner-barangay-${vehicleNumber}`).innerHTML = '<option value="">Select Barangay</option>';
        document.getElementById(`registered-owner-zip-${vehicleNumber}`).value = '';
        document.getElementById(`make-${vehicleNumber}`).value = '';
        document.getElementById(`model-${vehicleNumber}`).value = '';
        document.getElementById(`year-${vehicleNumber}`).value = '';
        document.getElementById(`color-${vehicleNumber}`).value = '';
        document.getElementById(`registered-owner-name-${vehicleNumber}`).value = '';

        // Clear file inputs
        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const orPreview = document.getElementById(`or-reg-preview-${vehicleNumber}`);
        const crPreview = document.getElementById(`cr-reg-preview-${vehicleNumber}`);

        if (orInput && crInput) {
            orInput.value = ''; // Clear the input
            crInput.value = ''; // Clear the input
            orPreview.style.display = 'none'; // Hide the preview
            crPreview.style.display = 'none'; // Hide the preview
        }

        console.log(`Inputs for vehicle ${vehicleNumber} cleared`);
    }

    // Store the last selected files
    const state = {
        lastDlFrontFile: null,
        lastDlBackFile: null,
        lastOrFile1: null,
        lastCrFile1: null,
        lastOrFile2: null,
        lastCrFile2: null,
    };

    // Function to handle file preview
    function handleFilePreview(input, preview, lastFileVar) {
        const file = input.files[0];

        if (!file && lastFileVar) {
            return lastFileVar;
        }

        if (file && file.type.startsWith('image/')) {
            lastFileVar = file;
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
            return lastFileVar;
        }
        return null;
    }

    // Bind events for file inputs (personal information)
    function initPersonalFilePreviews() {
        const dlFrontInput = document.getElementById('dl-reg-front');
        const dlBackInput = document.getElementById('dl-reg-back');
        const dlFrontPreview = document.getElementById('dl-reg-preview-front');
        const dlBackPreview = document.getElementById('dl-reg-preview-back');

        if (dlFrontInput && dlBackInput) {
            dlFrontInput.addEventListener('change', function () {
                state.lastDlFrontFile = handleFilePreview(dlFrontInput, dlFrontPreview, state.lastDlFrontFile);
            });

            dlBackInput.addEventListener('change', function () {
                state.lastDlBackFile = handleFilePreview(dlBackInput, dlBackPreview, state.lastDlBackFile);
            });
        }
    }

    // Bind events for file inputs (vehicles)
    function initFilePreviews(vehicleNumber) {
        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const orPreview = document.getElementById(`or-reg-preview-${vehicleNumber}`);
        const crPreview = document.getElementById(`cr-reg-preview-${vehicleNumber}`);

        if (orInput && crInput) {
            orInput.addEventListener('change', function () {
                state[`lastOrFile${vehicleNumber}`] = handleFilePreview(orInput, orPreview, state[`lastOrFile${vehicleNumber}`]);
            });

            crInput.addEventListener('change', function () {
                state[`lastCrFile${vehicleNumber}`] = handleFilePreview(crInput, crPreview, state[`lastCrFile${vehicleNumber}`]);
            });
        }
    }

    // Initialize file previews for personal information and Vehicle 1
    initPersonalFilePreviews();
    initFilePreviews(1); // Ensure Vehicle 1 file previews are initialized

    // Image preview modal handling
    const imagePreviewModal = document.getElementById('imagePreviewModal');
    const modalImage = document.getElementById('modalImage');
    const previewCloseBtn = imagePreviewModal ? imagePreviewModal.querySelector('.close') : null;

    document.querySelectorAll('.img-preview').forEach(preview => {
        preview.addEventListener('click', function () {
            if (modalImage && imagePreviewModal) {
                modalImage.src = this.src;
                imagePreviewModal.style.display = 'block';
                console.log("Image preview modal displayed");
            }
        });
    });

    if (previewCloseBtn) {
        previewCloseBtn.onclick = function () {
            imagePreviewModal.style.display = 'none';
        };
    }

    // Show warning modal for missing files
    function showWarningModal(missingFiles) {
        const warningList = document.getElementById('warning-list');
        if (warningList) {
            console.log("Displaying warning modal with missing files:", missingFiles);
            warningList.innerHTML = '';
            missingFiles.forEach(file => {
                const listItem = document.createElement('p');
                listItem.innerHTML = `<i class="fas fa-exclamation-circle" style="color: orange;"></i> ${file}`;
                warningList.appendChild(listItem);
            });
        }
        const warningModal = document.getElementById('warningModal');
        if (warningModal) {
            warningModal.style.display = 'block';
            console.log("Warning modal displayed");
        }
    }

    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.onclick = function () {
            const warningModal = document.getElementById('warningModal');
            if (warningModal) warningModal.style.display = 'none';
            const confirmationModal = document.getElementById('confirmationModal');
            if (confirmationModal) confirmationModal.style.display = 'none';
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            if (imagePreviewModal) imagePreviewModal.style.display = 'none';
            console.log("Modal closed");
        };
    });

    window.onclick = function (event) {
        const warningModal = document.getElementById('warningModal');
        const confirmationModal = document.getElementById('confirmationModal');
        if (event.target === warningModal) {
            warningModal.style.display = 'none';
            console.log("Warning modal hidden on outside click");
        } else if (event.target === confirmationModal) {
            confirmationModal.style.display = 'none';
            console.log("Confirmation modal hidden on outside click");
        } else if (event.target === imagePreviewModal) {
            imagePreviewModal.style.display = 'none';
            console.log("Image preview modal hidden on outside click");
        }
    };

    // Show confirmation modal after validation
    window.showConfirmationModal = function () {
        console.log("Triggered showConfirmationModal");
        const missingFiles = [];

        // Validate personal info uploads
        if (!state.lastDlFrontFile) missingFiles.push("Driver's License (Front)");
        if (!state.lastDlBackFile) missingFiles.push("Driver's License (Back)");

        // Validate vehicle section uploads for Vehicle 1
        if (!state.lastOrFile1) missingFiles.push("OR for Vehicle 1");
        if (!state.lastCrFile1) missingFiles.push("CR for Vehicle 1");

        // Validate vehicle section uploads for Vehicle 2 (if vehicle 2 is added)
        if (vehicleCount === 2) {
            if (!state.lastOrFile2) missingFiles.push("OR for Vehicle 2");
            if (!state.lastCrFile2) missingFiles.push("CR for Vehicle 2");
        }

        if (missingFiles.length > 0) {
            console.log("Missing files: ", missingFiles); // Debugging log
            showWarningModal(missingFiles);
        } else {
            updateConfirmationModal();
            const confirmationModal = document.getElementById('confirmationModal');
            if (confirmationModal) {
                confirmationModal.style.display = 'block';
                console.log("Confirmation modal displayed");
            }
        }
    };

    // Update confirmation modal content with document previews and names
    function updateConfirmationModal() {
        let modalContent = '';

        // Personal Info - Driver's License Front
        if (state.lastDlFrontFile) {
            modalContent += `<div><strong>Driver's License (Front):</strong><br>
                <img src="${document.getElementById('dl-reg-preview-front').src}" alt="Driver's License Front" class="confirmation-img"><br>
                File Name: ${state.lastDlFrontFile.name}
            </div><br>`;
        } else {
            modalContent += `<strong>Driver's License (Front):</strong> Not uploaded<br>`;
        }

        // Personal Info - Driver's License Back
        if (state.lastDlBackFile) {
            modalContent += `<div><strong>Driver's License (Back):</strong><br>
                <img src="${document.getElementById('dl-reg-preview-back').src}" alt="Driver's License Back" class="confirmation-img"><br>
                File Name: ${state.lastDlBackFile.name}
            </div><br>`;
        } else {
            modalContent += `<strong>Driver's License (Back):</strong> Not uploaded<br>`;
        }

        // Vehicle 1 - OR
        if (state.lastOrFile1) {
            modalContent += `<div><strong>OR for Vehicle 1:</strong><br>
                <img src="${document.getElementById('or-reg-preview-1').src}" alt="OR for Vehicle 1" class="confirmation-img"><br>
                File Name: ${state.lastOrFile1.name}
            </div><br>`;
        } else {
            modalContent += `<strong>OR for Vehicle 1:</strong> Not uploaded<br>`;
        }

        // Vehicle 1 - CR
        if (state.lastCrFile1) {
            modalContent += `<div><strong>CR for Vehicle 1:</strong><br>
                <img src="${document.getElementById('cr-reg-preview-1').src}" alt="CR for Vehicle 1" class="confirmation-img"><br>
                File Name: ${state.lastCrFile1.name}
            </div><br>`;
        } else {
            modalContent += `<strong>CR for Vehicle 1:</strong> Not uploaded<br>`;
        }

        // Vehicle 2 (if applicable)
        if (vehicleCount === 2) {
            if (state.lastOrFile2) {
                modalContent += `<div><strong>OR for Vehicle 2:</strong><br>
                    <img src="${document.getElementById('or-reg-preview-2').src}" alt="OR for Vehicle 2" class="confirmation-img"><br>
                    File Name: ${state.lastOrFile2.name}
                </div><br>`;
            } else {
                modalContent += `<strong>OR for Vehicle 2:</strong> Not uploaded<br>`;
            }

            if (state.lastCrFile2) {
                modalContent += `<div><strong>CR for Vehicle 2:</strong><br>
                    <img src="${document.getElementById('cr-reg-preview-2').src}" alt="CR for Vehicle 2" class="confirmation-img"><br>
                    File Name: ${state.lastCrFile2.name}
                </div><br>`;
            } else {
                modalContent += `<strong>CR for Vehicle 2:</strong> Not uploaded<br>`;
            }
        }

        const confirmationModalContent = document.getElementById('confirmation-modal-content');
        if (confirmationModalContent) {
            confirmationModalContent.innerHTML = modalContent;
        }
    }

    // Trigger confirmation modal on submit
    const submitButton = document.querySelector('.btn-submit');
    if (submitButton) {
        submitButton.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Submit button clicked");
            showConfirmationModal();
        });
    }
});
