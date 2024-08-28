
// Show and hide sections based on click
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
}

// Initially display the dashboard section
showSection('dashboard');

// Function to set active class on clicked navigation link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');
        showSection(this.getAttribute('onclick').match(/'([^']+)'/)[1]);
    });
});

// Set the date input to today's date
document.getElementById('date-picker').valueAsDate = new Date();

// Preview uploaded image
function loadFile(event) {
    var avatarImage = document.getElementById('avatarImage');
    avatarImage.src = URL.createObjectURL(event.target.files[0]);
}

// Reset the form fields and profile picture
document.getElementById('resetButton').addEventListener('click', function() {
    // Reset the form fields to their default values
    document.getElementById('profileForm').reset();
    
    // Reset the profile picture to its original source
    document.getElementById('avatarImage').src = "https://bootdey.com/img/Content/avatar/avatar1.png";
    
    // If needed, reset the file input
    document.querySelector('input[name="avatar"]').value = "";
});
