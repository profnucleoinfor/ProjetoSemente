document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.main-nav a');
    navLinks.forEach(function (link) {
        const currentPath = window.location.pathname.replace(/\/+$/, '') || '/index.php';
        const linkPath = link.getAttribute('href') || '';
        const normalizedLink = linkPath.replace(/\/+$/, '');

        if (normalizedLink === currentPath) {
            link.setAttribute('aria-current', 'page');
        }
    });
});
