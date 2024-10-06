// Show and hide sections based on click
// function showSection(sectionId) {
//     const sections = document.querySelectorAll('.content-section');
//     sections.forEach(section => {
//         section.style.display = 'none';
//     });

//     // Check if the section exists before attempting to change its style
//     const targetSection = document.getElementById(sectionId);
//     if (targetSection) {
//         targetSection.style.display = 'block';
//     } else {
//         console.error(`Section with ID '${sectionId}' not found.`);
//     }
// }

// Initially display the dashboard section
showSection('dashboard');

// Function to set active class on clicked navigation link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');

        // Safely get the sectionId from the onclick attribute
        const sectionId = this.getAttribute('onclick').match(/'([^']+)'/);
        if (sectionId) {
            showSection(sectionId[1]);
        } else {
            console.error("No valid section ID found in the 'onclick' attribute.");
        }
    });
});

// Set the date input to today's date
// const datePicker = document.getElementById('date-picker');
// if (datePicker) {
//     datePicker.valueAsDate = new Date();
// } else {
//     console.error("Date picker not found.");
// }

// // Preview uploaded image
// function loadFile(event) {
//     var avatarImage = document.getElementById('avatarImage');
//     if (avatarImage) {
//         avatarImage.src = URL.createObjectURL(event.target.files[0]);
//     } else {
//         console.error("Avatar image element not found.");
//     }
// }

// // Reset the form fields and profile picture
// const resetButton = document.getElementById('resetButton');
// if (resetButton) {
//     resetButton.addEventListener('click', function() {
//         // Reset the form fields to their default values
//         const profileForm = document.getElementById('profileForm');
//         if (profileForm) {
//             profileForm.reset();
//         } else {
//             console.error("Profile form not found.");
//         }

//         // Reset the profile picture to its original source
//         const avatarImage = document.getElementById('avatarImage');
//         if (avatarImage) {
//             avatarImage.src = "https://bootdey.com/img/Content/avatar/avatar1.png";
//         } else {
//             console.error("Avatar image element not found.");
//         }

//         // If needed, reset the file input
//         const avatarInput = document.querySelector('input[name="avatar"]');
//         if (avatarInput) {
//             avatarInput.value = "";
//         } else {
//             console.error("Avatar input element not found.");
//         }
//     });
// } else {
//     console.error("Reset button not found.");
// }
