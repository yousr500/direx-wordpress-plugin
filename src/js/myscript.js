
// myscript.js
document.addEventListener('DOMContentLoaded', () => {
    const tabWrapper = document.querySelector('.wrap');
    if (!tabWrapper) return;

    // Tab functionality
    const tabs = tabWrapper.querySelectorAll('.nav-tabs > li > a');
    const tabPanes = tabWrapper.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();

            // Remove active class from all tabs and panes
            tabs.forEach(t => t.parentElement.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            // Add active class to clicked tab and corresponding pane
            const targetTab = e.currentTarget;
            const targetPane = document.querySelector(targetTab.getAttribute('href'));

            targetTab.parentElement.classList.add('active');
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });

    // Form submission handling
    const form = tabWrapper.querySelector('form');
    if (form) {
        form.addEventListener('submit', () => {
           
        });
    }
});