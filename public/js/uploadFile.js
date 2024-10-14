document.addEventListener('DOMContentLoaded', function () {
    let vehicleCount = 1;
    const termsModal = document.getElementById('termsModal');
    const acceptTerms = document.getElementById('acceptTerms');
    const declineTerms = document.getElementById('declineTerms');
    const closeBtn = document.querySelector('.modal .close');
    const vehicleForm = document.querySelector('.home-content');
    const userId = window.userId;

    const cookieName = `termsAgreed_${userId}`;

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()[]\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

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
        if (event.target === termsModal) {
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

    function updateIDLabel() {
        const role = document.getElementById('role').value;
        const idLabel = document.querySelector('label[for="id"]');
        const labelText = {
            'Student': 'Student ID',
            'Faculty': 'Employee ID',
            'Parent': 'Parent ID',
            'Tenant': 'Tenant ID',
        };
        idLabel.innerHTML = `${labelText[role] || 'ID'} <span class="text-danger">*</span>:`;
    }

    updateIDLabel();

    const userRole = document.getElementById('role').value;

    function handleSupportDocumentRequirement(vehicleNumber) {
        const supportDocsSection = document.getElementById(`support-doc-section-${vehicleNumber}`);
        const supportDocInput = document.getElementById(`support-doc-${vehicleNumber}`);

        if (userRole === 'Student' || userRole === 'Parent') {
            supportDocsSection.style.display = 'block';
            supportDocInput.required = true;
            supportDocInput.disabled = false;
        } else {
            supportDocsSection.style.display = 'none';
            supportDocInput.required = false;
            supportDocInput.disabled = true;
        }
    }

    handleSupportDocumentRequirement(1);
    handleSupportDocumentRequirement(2);

    

    function handleVehicleTypeChange(vehicleNumber) {
        const vehicleTypeInputs = document.querySelectorAll(`input[name="vehicles[${vehicleNumber - 1}][vehicle_type]"]`);
        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const expiryDateInput = document.querySelector(`input[name="documents[${(vehicleNumber - 1) * 3}][expiry_date]"]`);
        const licensePlateInput = document.getElementById(`license-plate-number-${vehicleNumber}`);
        const certificateOwnershipGroup = document.getElementById(`CO-${vehicleNumber}`);
        const certificateOwnershipInput = document.getElementById(`certificate-ownership-reg-${vehicleNumber}`);

        vehicleTypeInputs.forEach(input => {
            input.addEventListener('change', function () {
                const isElectronicVehicle = this.value === 'electronic_vehicle';

                orInput.closest('.upload-group').style.display = isElectronicVehicle ? 'none' : 'flex';
                crInput.closest('.upload-group').style.display = isElectronicVehicle ? 'none' : 'flex';
                expiryDateInput.closest('.form-group').style.display = isElectronicVehicle ? 'none' : 'block';
                licensePlateInput.closest('.form-group').style.display = isElectronicVehicle ? 'none' : 'block';
                certificateOwnershipGroup.style.display = isElectronicVehicle ? 'flex' : 'none';
                certificateOwnershipInput.required = isElectronicVehicle;

                orInput.disabled = isElectronicVehicle;
                crInput.disabled = isElectronicVehicle;
                expiryDateInput.disabled = isElectronicVehicle;
                licensePlateInput.disabled = isElectronicVehicle;
            });
        });

        const selectedVehicleType = document.querySelector(`input[name="vehicles[${vehicleNumber - 1}][vehicle_type]"]:checked`);
        if (selectedVehicleType) selectedVehicleType.dispatchEvent(new Event('change'));
    }

    handleVehicleTypeChange(1);

    function loadProvinces(vehicleNumber) {
        const provinceSelect = document.getElementById(`registered-owner-province-${vehicleNumber}`);
        const municipalitySelect = document.getElementById(`registered-owner-municipality-${vehicleNumber}`);
        const barangaySelect = document.getElementById(`registered-owner-barangay-${vehicleNumber}`);
        const zipCodeInput = document.getElementById(`registered-owner-zip-${vehicleNumber}`);

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
                            option.value = municipality.name;
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
                            option.value = barangay.name;
                            option.text = barangay.name;
                            barangaySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching barangays:', error));

                const selectedMunicipality = municipalitySelect.options[municipalitySelect.selectedIndex].text;
                fetch(`/zipcode?municipality=${selectedMunicipality}`)
                    .then(response => response.json())
                    .then(data => {
                        zipCodeInput.value = data.zipcode || '';
                    })
                    .catch(() => {
                        zipCodeInput.value = '';
                    });
            }
        });

        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.text = province.name;
                    option.dataset.provinceCode = province.code;
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));
    }

    loadProvinces(1);

    function loadVehicleProvinces(vehicleNumber) {
        const vehicleProvinceSelect = document.getElementById(`province-${vehicleNumber}`);
        
        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                vehicleProvinceSelect.innerHTML = '<option value="">Select Province</option>';
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.text = province.name;
                    option.dataset.provinceCode = province.code;
                    vehicleProvinceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));
    }
    
    loadVehicleProvinces(1);

    window.addVehicle = function () {
        if (vehicleCount < 2) {
            const vehicleSection2 = document.getElementById('vehicle-section-2');
            if (vehicleSection2) {
                vehicleSection2.style.display = 'block';
                loadProvinces(2);
                loadVehicleProvinces(2);
                handleVehicleTypeChange(2);
                handleSupportDocumentRequirement(2);
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
                state.lastSupDoc2 = null;
                state.lastCertOwn2 = null;
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
        const supportDocInput = document.getElementById(`support-doc-${vehicleNumber}`);
        const supportDocPreview = document.getElementById(`support-doc-preview-${vehicleNumber}`);
        const certificateOwnershipInput = document.getElementById(`certificate-ownership-reg-${vehicleNumber}`);
        const certificateOwnershipPreview = document.getElementById(`certificate-ownership-preview-${vehicleNumber}`);

        if (orInput && crInput) {
            orInput.value = '';
            crInput.value = '';
            supportDocInput.value = '';
            certificateOwnershipInput.value= '';
            certificateOwnershipPreview.style.display = 'none';
            supportDocPreview.style.display = 'none';
            orPreview.style.display = 'none';
            crPreview.style.display = 'none';
        }
    }

    const state = {
        lastOrFile1: null,
        lastCrFile1: null,
        lastOrFile2: null,
        lastCrFile2: null,
        lastSupDoc1: null,
        lastSupDoc2: null,
        lastCertOwn1: null,
        lastCertOwn2: null,
    };

    function handleFileInput(inputElement, previewElement) {
        if (!inputElement || !previewElement) {
            return; 
        }
        inputElement.addEventListener('change', function () {
            const file = inputElement.files[0];
            if (file) {
                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewElement.src = e.target.result;
                        previewElement.style.display = 'block';
                        previewElement.closest('.upload-group').querySelector('.file-info').innerHTML = '';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.style.display = 'none';
                    const fileInfoElement = previewElement.closest('.upload-group').querySelector('.file-info');
                    if (fileInfoElement) {
                        fileInfoElement.innerHTML = `<img src="${pdfIconUrl}" alt="PDF" style="height:100%; width:100%;"> ${file.name}`;
                    }
                }
            }
        });
    }

    initFilePreviews(1);

    if (document.getElementById('vehicle-section-2')) {
        initFilePreviews(2);
    }

    function initFilePreviews(vehicleNumber) {
        const orInput = document.getElementById(`or-reg-${vehicleNumber}`);
        const crInput = document.getElementById(`cr-reg-${vehicleNumber}`);
        const supportDocInput = document.getElementById(`support-doc-${vehicleNumber}`);
        const orPreview = document.getElementById(`or-reg-preview-${vehicleNumber}`);
        const crPreview = document.getElementById(`cr-reg-preview-${vehicleNumber}`);
        const supportDocPreview = document.getElementById(`support-doc-preview-${vehicleNumber}`);
        const certificateOwnershipInput = document.getElementById(`certificate-ownership-reg-${vehicleNumber}`);
        const certificateOwnershipPreview = document.getElementById(`certificate-ownership-preview-${vehicleNumber}`);

        handleFileInput(orInput, orPreview);
        handleFileInput(crInput, crPreview);
        handleFileInput(supportDocInput, supportDocPreview);
        handleFileInput(certificateOwnershipInput, certificateOwnershipPreview);
    }

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
    
        const userRole = document.getElementById('role').value;
        const vehicle1Type = document.querySelector('input[name="vehicles[0][vehicle_type]"]:checked')?.value;
    
        if (vehicle1Type === 'fueled_vehicle') {
            if (!document.getElementById('or-reg-1').files.length) missingFiles.push("OR for Vehicle 1");
            if (!document.getElementById('cr-reg-1').files.length) missingFiles.push("CR for Vehicle 1");
            if (!document.querySelector('input[name="documents[0][expiry_date]"]').value) missingFiles.push("Expiry Date for OR/CR of Vehicle 1");
            if ((userRole === 'Student' || userRole === 'Parent') && !document.getElementById('support-doc-1').files.length) missingFiles.push("Support Document for Vehicle 1");
        } else if (vehicle1Type === 'electronic_vehicle') {
            if (!document.getElementById('certificate-ownership-reg-1').files.length) missingFiles.push("Certificate of Ownership for Vehicle 1");
            if ((userRole === 'Student' || userRole === 'Parent') && !document.getElementById('support-doc-1').files.length) missingFiles.push("Support Document for Vehicle 1");
        }
        
        const vehicle2Section = document.getElementById('vehicle-section-2');
        if (vehicle2Section && vehicle2Section.style.display !== 'none') {
            const vehicle2Type = document.querySelector('input[name="vehicles[1][vehicle_type]"]:checked')?.value;
    
            if (vehicle2Type === 'fueled_vehicle') {
                if (!document.getElementById('or-reg-2').files.length) missingFiles.push("OR for Vehicle 2");
                if (!document.getElementById('cr-reg-2').files.length) missingFiles.push("CR for Vehicle 2");
                if (!document.querySelector('input[name="documents[3][expiry_date]"]').value) missingFiles.push("Expiry Date for OR/CR of Vehicle 2");
                if ((userRole === 'Student' || userRole === 'Parent') && !document.getElementById('support-doc-2').files.length) missingFiles.push("Support Document for Vehicle 2");
            } else if (vehicle2Type === 'electronic_vehicle') {
                if (!document.getElementById('certificate-ownership-reg-2').files.length) missingFiles.push("Certificate of Ownership for Vehicle 2");
                if ((userRole === 'Student' || userRole === 'Parent') && !document.getElementById('support-doc-2').files.length) missingFiles.push("Support Document for Vehicle 2");
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
        let valid = true;
        document.querySelectorAll('input[type="file"]').forEach(input => {
            if (input.files.length) {
                const fileType = input.files[0].type;
                const isCertificate = input.id.includes('certificate-ownership');
                const isSupportDoc = input.id.includes('support-doc');

                if (isSupportDoc && fileType !== 'application/pdf') {
                    alert(`Invalid file type: ${fileType}. The support document only accepts PDF files.`);
                    valid = false;
                } else if (isCertificate && !(fileType === 'application/pdf' || fileType.startsWith('image/'))) {
                    alert(`Invalid file type: ${fileType}. The Certificate of Ownership only accepts PDF or image files.`);
                    valid = false;
                } else if (!isCertificate && !isSupportDoc && !fileType.startsWith('image/')) {
                    alert(`Invalid file type: ${fileType}. Please upload a JPG or PNG file.`);
                    valid = false;
                }
            }
        });
        return valid;
    }
    
    function removeUnusedFields() {
        if (vehicleCount < 2) {
            const vehicle2Section = document.getElementById('vehicle-section-2');
            if (vehicle2Section && vehicle2Section.style.display === 'none') {
                vehicle2Section.querySelectorAll('input, select').forEach(field => {
                    field.disabled = true;
                });
            }
        }
    
        document.querySelectorAll('input[type="file"]').forEach(input => {
            if (!input.files.length) {
                input.disabled = true;
            }
        });
    }

    document.getElementById('confirmSubmit').addEventListener('click', function (event) {
        if (validateFileTypes()) {
            const vehicle1Type = document.querySelector('input[name="vehicles[0][vehicle_type]"]:checked')?.value;
            if (vehicle1Type === 'electronic_vehicle' && !document.getElementById('certificate-ownership-reg-1').files.length) {
                alert("Please upload a Certificate of Ownership for the electronic vehicle.");
                event.preventDefault();
                return;
            }

            const vehicle2Type = document.querySelector('input[name="vehicles[1][vehicle_type]"]:checked')?.value;
            if (vehicle2Type === 'electronic_vehicle' && !document.getElementById('certificate-ownership-reg-2').files.length) {
                alert("Please upload a Certificate of Ownership for the second electronic vehicle.");
                event.preventDefault();
                return;
            }

            document.getElementById('vehicle-registration-form').submit();
        } else {
            event.preventDefault();
        }
    });

    document.querySelectorAll('input[type="file"]').forEach(input => {
        console.log(`${input.id} disabled: ${input.disabled} has file: ${input.files.length > 0}`);
    });

    document.getElementById('confirmSubmit').addEventListener('click', function (event) {
        document.querySelectorAll('input, select').forEach(input => {
            if (!input.disabled) {
                console.log(`${input.name}: ${input.value}`);
            }
        });
    
        if (validateFileTypes()) {
            removeUnusedFields();
            document.getElementById('vehicle-registration-form').submit();
        } else {
            event.preventDefault();
        }
    });

    
});
