document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.querySelector('.nav-link[onclick]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('admin-logout-form').submit();
            }
        });
    }
});
document.addEventListener("DOMContentLoaded", function() {
    var dropdownBtn = document.querySelector(".dropdown-btn");
    var dropdownContainer = document.querySelector(".dropdown-container");
    var sidebar = document.querySelector(".sidebar");

    // Toggle dropdown on Settings button click
    dropdownBtn.addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent the click from immediately closing due to mouseleave
        dropdownContainer.style.display = dropdownContainer.style.display === "block" ? "none" : "block";
    });

    // Close the dropdown and remove active class when the mouse leaves the sidebar
    sidebar.addEventListener("mouseleave", function() {
        dropdownContainer.style.display = "none";
        dropdownBtn.classList.remove("active");
    });

    // Add or remove the active class based on the dropdown state
    dropdownBtn.addEventListener("click", function() {
        dropdownBtn.classList.toggle("active");
    });
});






