import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Theme Toggle Functionality
(function() {
    // Check for saved theme preference or default to light mode
    const getTheme = () => {
        if (localStorage.getItem('theme')) {
            return localStorage.getItem('theme');
        }
        // Check system preference
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    };

    const setTheme = (theme) => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('theme', theme);
    };

    // Initialize theme on page load
    setTheme(getTheme());

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            setTheme(e.matches ? 'dark' : 'light');
        }
    });

    // Update theme toggle icons
    const updateThemeIcons = () => {
        const isDark = document.documentElement.classList.contains('dark');
        const lightIcons = document.querySelectorAll('#theme-toggle-light-icon, #theme-toggle-light-icon-mobile');
        const darkIcons = document.querySelectorAll('#theme-toggle-dark-icon, #theme-toggle-dark-icon-mobile');
        
        lightIcons.forEach(icon => {
            icon.classList.toggle('hidden', isDark);
        });
        darkIcons.forEach(icon => {
            icon.classList.toggle('hidden', !isDark);
        });
    };

    // Expose toggle function globally
    window.toggleTheme = () => {
        const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
        updateThemeIcons();
    };

    // Get current theme
    window.getCurrentTheme = () => {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    };

    // Update icons on page load
    updateThemeIcons();

    // Watch for theme changes (in case theme is changed elsewhere)
    const observer = new MutationObserver(() => {
        updateThemeIcons();
    });
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
})();
