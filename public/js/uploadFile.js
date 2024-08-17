document.addEventListener('DOMContentLoaded', function () {
    // Store the last selected files
    const state = {
        lastDlFrontFile: null,
        lastDlBackFile: null,
        lastOrFile: null,
        lastCrFile: null,
    };

    // Query initial file input elements for Personal Information
    const dlFrontInput = document.getElementById('dl-reg-front');
    const dlBackInput = document.getElementById('dl-reg-back');
    const dlFrontPreview = document.getElementById('dl-reg-preview-front');
    const dlBackPreview = document.getElementById('dl-reg-preview-back');

    // Modal elements
    const imagePreviewModal = document.getElementById('imagePreviewModal');
    const modalImage = document.getElementById('modalImage');
    const previewCloseBtn = imagePreviewModal.querySelector('.close');

    const confirmationModal = document.getElementById('confirmationModal');
    const confirmCloseBtn = confirmationModal.querySelector('.close');
    const confirmSubmitBtn = document.getElementById('confirmSubmit');

    const warningModal = document.getElementById('warningModal');
    const warningList = document.getElementById('warning-list');
    const warningCloseBtn = warningModal.querySelector('.close');

    // Function to handle file preview for each input
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

    // Bind events for personal information file inputs
    dlFrontInput.addEventListener('change', function () {
        state.lastDlFrontFile = handleFilePreview(dlFrontInput, dlFrontPreview, state.lastDlFrontFile);
    });

    dlBackInput.addEventListener('change', function () {
        state.lastDlBackFile = handleFilePreview(dlBackInput, dlBackPreview, state.lastDlBackFile);
    });

    // Bind events for vehicle information file inputs
    const orInput = document.getElementById('or-reg-1');
    const crInput = document.getElementById('cr-reg-1');
    const orPreview = document.getElementById('or-reg-preview-1');
    const crPreview = document.getElementById('cr-reg-preview-1');

    orInput.addEventListener('change', function () {
        state.lastOrFile = handleFilePreview(orInput, orPreview, state.lastOrFile);
    });

    crInput.addEventListener('change', function () {
        state.lastCrFile = handleFilePreview(crInput, crPreview, state.lastCrFile);
    });

    // Image preview modal handling
    document.querySelectorAll('.img-preview').forEach(preview => {
        preview.addEventListener('click', function () {
            modalImage.src = this.src;
            imagePreviewModal.style.display = 'block';
        });
    });

    previewCloseBtn.onclick = function () {
        imagePreviewModal.style.display = 'none';
    };

    // Show warning modal for missing files
    function showWarningModal(missingFiles) {
        warningList.innerHTML = '';
        missingFiles.forEach(file => {
            const listItem = document.createElement('p');
            listItem.innerHTML = `<i class="fas fa-exclamation-circle" style="color: orange;"></i> ${file}`;
            warningList.appendChild(listItem);
        });
        warningModal.style.display = 'block';
    }

    warningCloseBtn.onclick = function () {
        warningModal.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target === warningModal) {
            warningModal.style.display = 'none';
        }
    };

    // Show confirmation modal after validation
    function showConfirmationModal() {
        const missingFiles = [];

        if (!state.lastDlFrontFile) missingFiles.push("Driver's License (Front)");
        if (!state.lastDlBackFile) missingFiles.push("Driver's License (Back)");

        if (!state.lastOrFile) missingFiles.push("OR");
        if (!state.lastCrFile) missingFiles.push("CR");

        if (missingFiles.length > 0) {
            showWarningModal(missingFiles);
        } else {
            updateConfirmationModal();
            confirmationModal.style.display = 'block';
        }
    }

    // Update confirmation modal content
    function updateConfirmationModal() {
        let modalContent = '';
        modalContent += `<strong>Driver's License (Front):</strong> ${state.lastDlFrontFile?.name || 'Not selected'}<br>`;
        modalContent += `<strong>Driver's License (Back):</strong> ${state.lastDlBackFile?.name || 'Not selected'}<br>`;
        modalContent += `<strong>OR:</strong> ${state.lastOrFile?.name || 'Not selected'}<br>`;
        modalContent += `<strong>CR:</strong> ${state.lastCrFile?.name || 'Not selected'}<br>`;

        document.getElementById('confirmation-modal-content').innerHTML = modalContent;
    }

    confirmCloseBtn.onclick = function () {
        confirmationModal.style.display = 'none';
    };

    confirmSubmitBtn.onclick = function () {
        alert('Form submitted successfully');
        confirmationModal.style.display = 'none';
    };

    // Trigger confirmation modal on submit
    const submitButton = document.querySelector('.btn-submit');
    submitButton.addEventListener('click', function (event) {
        event.preventDefault();
        showConfirmationModal();
    });
});
