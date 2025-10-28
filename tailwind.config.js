import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'autosocial-primary': '#1D4ED8', // Deep Blue
                'autosocial-secondary': '#06B6D4', // Cyan (for AI/Automated)
                'autosocial-bg': '#F8FAFC', // Very clear background
                'autosocial-card': '#FFFFFF', // Card background
            },
        },
    },

    plugins: [forms],
};
