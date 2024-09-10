document.addEventListener('DOMContentLoaded', function () {
    let vehicleCount = 1; // Track the number of vehicles (1 by default)

    // Show the terms and conditions modal on page load
    const termsModal = document.getElementById('termsModal');
    const acceptTerms = document.getElementById('acceptTerms');
    const declineTerms = document.getElementById('declineTerms');
    const closeBtn = document.querySelector('.modal .close');
    const vehicleForm = document.querySelector('.home-content');

    // Ensure userId is correctly passed from server-side
    const userId = window.userId;

    // Function to check if a cookie exists
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()[]\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    // Function to set a cookie
    function setCookie(name, value, options = {}) {
        options = { path: '/', ...options };
        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }
        let updatedCookie = `${encodeURIComponent(name)}=${encodeURIComponent(value)}`;
        for (let optionKey in options) {
            updatedCookie += `; ${optionKey}`;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += `=${optionValue}`;
            }
        }
        document.cookie = updatedCookie;
    }

    // Make the cookie user-specific
    const cookieName = `termsAgreed_${userId}`;

    // Check if the user has already agreed to the terms
    if (getCookie(cookieName) === 'true') {
        vehicleForm.style.pointerEvents = 'auto';
        vehicleForm.style.opacity = '1';
    } else {
        vehicleForm.style.pointerEvents = 'none';
        vehicleForm.style.opacity = '0.5';
        termsModal.style.display = 'block';
    }

    closeBtn.addEventListener('click', function () {
        termsModal.style.display = 'none';
    });

    window.onclick = function (event) {
        if (event.target == termsModal) {
            termsModal.style.display = 'none';
        }
    };

    acceptTerms.addEventListener('click', function () {
        termsModal.style.display = 'none';
        vehicleForm.style.pointerEvents = 'auto';
        vehicleForm.style.opacity = '1';
        setCookie(cookieName, 'true', { expires: new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000) });
    });

    declineTerms.addEventListener('click', function () {
        termsModal.style.display = 'none';
        alert("You must agree to the terms and conditions to interact with the form.");
    });

    // Function to change the ID label based on the user's type (role)
    function updateIDLabel() {
        const role = document.getElementById('role').value;
        const idLabel = document.querySelector('label[for="id"]');
        if (role === 'Student') {
            idLabel.innerHTML = 'Student ID <span class="text-danger">*</span>:';
        } else if (role === 'Faculty') {
            idLabel.innerHTML = 'Employee ID <span class="text-danger">*</span>:';
        } else if (role === 'Parent') {
            idLabel.innerHTML = 'Parent ID <span class="text-danger">*</span>:';
        } else if (role === 'Tenant') {
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
            const provinceCode = this.options[this.selectedIndex].dataset.provinceCode;
            if (provinceCode) {
                fetch(`/municipalities/${provinceCode}`)
                    .then(response => response.json())
                    .then(data => {
                        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                        data.forEach(municipality => {
                            const option = document.createElement('option');
                            option.value = municipality.name; // Store the municipal name instead of code
                            option.text = municipality.name;
                            option.dataset.municipalCode = municipality.code;
                            municipalitySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching municipalities:', error));
            }
        });
    
        municipalitySelect.addEventListener('change', function () {
            const municipalityCode = this.options[this.selectedIndex].dataset.municipalCode;
            if (municipalityCode) {
                fetch(`/barangays/${municipalityCode}`)
                    .then(response => response.json())
                    .then(data => {
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                        data.forEach(barangay => {
                            const option = document.createElement('option');
                            option.value = barangay.name; // Store the barangay name instead of code
                            option.text = barangay.name;
                            barangaySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching barangays:', error));
    
                const selectedMunicipality = municipalitySelect.options[municipalitySelect.selectedIndex].text;
                fetch(`/zipcode?municipality=${selectedMunicipality}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.zipcode) {
                            zipCodeInput.value = data.zipcode;
                        } else {
                            zipCodeInput.value = '';
                            alert('No ZIP code found for the selected municipality.');
                        }
                    })
                    .catch(error => {
                        zipCodeInput.value = '';
                        alert('Error fetching ZIP code. Please try again later.');
                    });
            }
        });
    
        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name; // Store the province name instead of code
                    option.text = province.name;
                    option.dataset.provinceCode = province.code;
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));
    }
    

    loadProvinces(1);

    window.addVehicle = function () {
        if (vehicleCount < 2) {
            const vehicleSection2 = document.getElementById('vehicle-section-2');
            if (vehicleSection2) {
                vehicleSection2.style.display = 'block';
                loadProvinces(2);
            }
            vehicleCount++;
            const addVehicleBtn = document.querySelector('.btn-add-vehicle');
            if (addVehicleBtn) {
                addVehicleBtn.disabled = true;
                addVehicleBtn.innerText = 'Maximum of 2 Vehicles Reached';
            }
            initFilePreviews(2);
        }
    };

    window.removeVehicle = function (vehicleNumber) {
        if (vehicleNumber === 2) {
            const vehicleSection2 = document.getElementById('vehicle-section-2');
            if (vehicleSection2) {
                vehicleSection2.style.display = 'none';
                state.lastOrFile2 = null;
                state.lastCrFile2 = null;
            }
            vehicleCount--;
            const addVehicleBtn = document.querySelector('.btn-add-vehicle');
            if (addVehicleBtn) {
                addVehicleBtn.disabled = false;
                addVehicleBtn.innerText = 'Add Another Vehicle';
            }
            clearVehicleSection(2);
        }
    };

    function clearVehicleSection(vehicleNumber) {
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

        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const orPreview = document.getElementById(`or-reg-preview-${vehicleNumber}`);
        const crPreview = document.getElementById(`cr-reg-preview-${vehicleNumber}`);

        if (orInput && crInput) {
            orInput.value = '';
            crInput.value = '';
            orPreview.style.display = 'none';
            crPreview.style.display = 'none';
        }
    }

    const state = {
        lastOrFile1: null,
        lastCrFile1: null,
        lastOrFile2: null,
        lastCrFile2: null,
    };

    function handleFilePreview(input, preview) {
        const file = input.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    function initFilePreviews(vehicleNumber) {
        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const orPreview = document.getElementById(`or-reg-preview-${vehicleNumber}`);
        const crPreview = document.getElementById(`cr-reg-preview-${vehicleNumber}`);

        if (orInput && crInput) {
            orInput.addEventListener('change', function () {
                handleFilePreview(orInput, orPreview);
            });

            crInput.addEventListener('change', function () {
                handleFilePreview(crInput, crPreview);
            });
        }
    }

    initFilePreviews(1);

    const imagePreviewModal = document.getElementById('imagePreviewModal');
    const modalImage = document.getElementById('modalImage');

    document.querySelectorAll('.img-preview').forEach(preview => {
        preview.addEventListener('click', function () {
            if (modalImage && imagePreviewModal) {
                modalImage.src = this.src;
                imagePreviewModal.style.display = 'block';
            }
        });
    });

    if (imagePreviewModal) {
        const previewCloseBtn = imagePreviewModal.querySelector('.close');
        if (previewCloseBtn) {
            previewCloseBtn.onclick = function () {
                imagePreviewModal.style.display = 'none';
            };
        }
    }

    function showWarningModal(missingFiles) {
        const warningList = document.getElementById('warning-list');
        if (warningList) {
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
        };
    });

    window.onclick = function (event) {
        const warningModal = document.getElementById('warningModal');
        const confirmationModal = document.getElementById('confirmationModal');
        const imagePreviewModal = document.getElementById('imagePreviewModal');
        if (event.target === warningModal) {
            warningModal.style.display = 'none';
        } else if (event.target === confirmationModal) {
            confirmationModal.style.display = 'none';
        } else if (event.target === imagePreviewModal) {
            imagePreviewModal.style.display = 'none';
        }
    };

    window.showConfirmationModal = function () {
        const missingFiles = [];
        let modalContent = '';
    
        if (document.getElementById('or-reg-1').files.length) {
            modalContent += `<div><strong>OR for Vehicle 1:</strong><br>
                <img src="${document.getElementById('or-reg-preview-1').src}" alt="OR for Vehicle 1" class="confirmation-img"><br>
                File Name: ${document.getElementById('or-reg-1').files[0].name}
            </div><br>`;
        } else {
            missingFiles.push("OR for Vehicle 1");
        }
    
        if (document.getElementById('cr-reg-1').files.length) {
            modalContent += `<div><strong>CR for Vehicle 1:</strong><br>
                <img src="${document.getElementById('cr-reg-preview-1').src}" alt="CR for Vehicle 1" class="confirmation-img"><br>
                File Name: ${document.getElementById('cr-reg-1').files[0].name}
            </div><br>`;
        } else {
            missingFiles.push("CR for Vehicle 1");
        }
    
        // Vehicle 2 Documents (only if vehicle 2 section is visible)
        if (document.getElementById('vehicle-section-2').style.display !== 'none') {
            if (document.getElementById('or-reg-2').files.length) {
                modalContent += `<div><strong>OR for Vehicle 2:</strong><br>
                    <img src="${document.getElementById('or-reg-preview-2').src}" alt="OR for Vehicle 2" class="confirmation-img"><br>
                    File Name: ${document.getElementById('or-reg-2').files[0].name}
                </div><br>`;
            } else {
                missingFiles.push("OR for Vehicle 2");
            }
    
            if (document.getElementById('cr-reg-2').files.length) {
                modalContent += `<div><strong>CR for Vehicle 2:</strong><br>
                    <img src="${document.getElementById('cr-reg-preview-2').src}" alt="CR for Vehicle 2" class="confirmation-img"><br>
                    File Name: ${document.getElementById('cr-reg-2').files[0].name}
                </div><br>`;
            } else {
                missingFiles.push("CR for Vehicle 2");
            }
        }
    
        if (missingFiles.length > 0) {
            showWarningModal(missingFiles);
        } else {
            const confirmationModalContent = document.getElementById('confirmation-modal-content');
            if (confirmationModalContent) {
                confirmationModalContent.innerHTML = modalContent;
            }
            document.getElementById('confirmationModal').style.display = 'block';
        }
    };

    function validateFileTypes() {
        const validFileTypes = ['image/jpeg', 'image/png'];
        let isValid = true;

        document.querySelectorAll('input[type="file"]').forEach(input => {
            if (input.files.length) {
                const fileType = input.files[0].type;
                if (!validFileTypes.includes(fileType)) {
                    isValid = false;
                    alert(`Invalid file type: ${fileType}. Please upload a JPG or PNG file.`);
                }
            }
        });

        return isValid;
    }

    function removeUnusedFields() {
        // Disable Vehicle 2 fields if it is not added
        if (vehicleCount < 2) {
            const vehicle2Section = document.getElementById('vehicle-section-2');
            if (vehicle2Section && vehicle2Section.style.display === 'none') {
                vehicle2Section.querySelectorAll('input, select').forEach(field => field.disabled = true);
            }
        }

        // Disable file inputs that have no selected file
        document.querySelectorAll('input[type="file"]').forEach(input => {
            if (!input.files.length) {
                input.disabled = true;
            }
        });
    }

    document.getElementById('confirmSubmit').addEventListener('click', function (event) {
        if (validateFileTypes()) {
            removeUnusedFields();
            document.getElementById('vehicle-registration-form').submit();
        } else {
            event.preventDefault();
        }
    });

    
    
});
