// Function to handle file preview for image inputs
function previewFile(inputId, imgPreviewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(imgPreviewId);
    const file = input.files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Function to display the existing file if available
function displayExistingFile(imgPreviewId) {
    const preview = document.getElementById(imgPreviewId);
    if (preview && preview.src && preview.src !== window.location.href) {
        preview.style.display = 'block'; // Ensure it's displayed if there is an existing image
    }
}

// Initialize previews when the page loads
document.addEventListener('DOMContentLoaded', () => {
    const dlFrontInput = document.getElementById('dl-reg-front');
    const dlBackInput = document.getElementById('dl-reg-back');
    const avatarImage = document.getElementById('avatarImage');

    // Display existing files on page load
    displayExistingFile('driver-license-front-preview');
    displayExistingFile('driver-license-back-preview');

    // Add event listeners to update previews only when a new file is selected
    if (dlFrontInput) {
        dlFrontInput.addEventListener('change', () => {
            previewFile('dl-reg-front', 'driver-license-front-preview');
        });
    }

    if (dlBackInput) {
        dlBackInput.addEventListener('change', () => {
            previewFile('dl-reg-back', 'driver-license-back-preview');
        });
    }

    // Add event listener to the avatar image for opening modal on click
    if (avatarImage) {
        avatarImage.addEventListener('click', function () {
            openImageModal(avatarImage);  // Reuse the modal opening function
        });
    }
});

// Function to open the image in a modal for a larger view
function openImageModal(imageElement) {
    const modal = document.getElementById('imagePreviewModal');
    const modalImage = document.getElementById('modalImage');

    modalImage.src = imageElement.src;
    modal.style.display = 'block';

    // Close the modal when the close button is clicked
    modal.querySelector('.close').onclick = function () {
        modal.style.display = 'none';
    };
}

// Function to handle preview of the profile picture
function previewProfilePicture(input) {
    const file = input.files[0];
    const reader = new FileReader();
    const preview = document.getElementById('avatarImage');

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Function to handle preview for other file inputs like driver's license
function previewFile(inputId, imgPreviewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(imgPreviewId);
    const file = input.files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}
