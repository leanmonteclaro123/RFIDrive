jQuery(document).ready(function($) {
    $('#aboutUsCarousel').carousel({
        interval: 2000 // Set the interval to 2 seconds for automatic sliding
    });

    $('.carousel-control-prev').click(function() {
        $('#aboutUsCarousel').carousel('prev');
    });

    $('.carousel-control-next').click(function() {
        $('#aboutUsCarousel').carousel('next');
    });

    const showMenu = (toggleId, navId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId);

        toggle.addEventListener('click', () => {
            nav.classList.toggle('show-menu');
            toggle.classList.toggle('show-icon');
        });
    };

    showMenu('nav-toggle', 'nav-menu');

    const navLinks = document.querySelectorAll('.nav__link[data-target]');
    const dropdownLinks = document.querySelectorAll('.dropdown__link[data-target]');
    const sections = document.querySelectorAll('.home-section');

    const handleSectionDisplay = (targetId) => {
        console.log('Target ID:', targetId);  // Log the target ID
        if (sections.length === 0) {
            console.error('No sections found!');
        }
        sections.forEach(section => {
            console.log('Section ID:', section.id);  // Log the section IDs
            if (section.id === targetId) {
                console.log('Showing section:', targetId);
                section.style.display = 'block';  // Ensure the section is displayed
            } else {
                section.style.display = 'none';  // Hide other sections
            }
        });
    };

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            console.log('Nav Link Clicked, Target:', targetId);  // Log the target from nav link
            handleSectionDisplay(targetId);
        });
    });

    dropdownLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            console.log('Dropdown Link Clicked, Target:', targetId);  // Log the target from dropdown link
            handleSectionDisplay(targetId);
        });
    });

    const navLinksAll = document.querySelectorAll('.nav__link');

    navLinksAll.forEach(link => {
        link.addEventListener('click', function() {
            navLinksAll.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
            const targetId = this.getAttribute('data-target');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

});
