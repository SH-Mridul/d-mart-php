const themeToggle = document.getElementById('themeToggle');
const toggleIcon = document.getElementById('toggleIcon');

// Check for saved theme in localStorage on page load
document.addEventListener('DOMContentLoaded', function () {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'night') {
        document.body.classList.add('night-mode');
        toggleIcon.classList.remove('bi-moon');
        toggleIcon.classList.add('bi-sun');
    } else {
        document.body.classList.add('day-mode');
        toggleIcon.classList.remove('bi-sun');
        toggleIcon.classList.add('bi-moon');
    }
});

themeToggle.addEventListener('click', function () {
    document.body.classList.toggle('night-mode');
    document.body.classList.toggle('day-mode');

    if (document.body.classList.contains('night-mode')) {
        toggleIcon.classList.remove('bi-moon');
        toggleIcon.classList.add('bi-sun');
        localStorage.setItem('theme', 'night'); // Save preference to localStorage
    } else {
        toggleIcon.classList.remove('bi-sun');
        toggleIcon.classList.add('bi-moon');
        localStorage.setItem('theme', 'day'); // Save preference to localStorage
    }
});