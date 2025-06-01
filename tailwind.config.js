import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
  darkMode: 'media',
    theme: {
        extend: {

          colors: {
                        primary: '#10B981', // Emerald-500 - Light green primary
                        secondary: '#34D399', // Emerald-400 - Lighter green
                        accent: '#059669', // Emerald-600 - Darker green accent
                        yellow: '#FCD34D', // Amber-300
                        teal: '#14B8A6', // Teal-500
                        orange: '#F59E0B', // Amber-500
                        dark: '#064E3B', // Emerald-900 - Dark green instead of blue
                        'dark-green': '#065F46', // Emerald-800
                        'light-green': '#D1FAE5', // Emerald-100
                        'soft-green': '#A7F3D0', // Emerald-200
                    },
            fontFamily: {
                sans: ['Nunito', 'sans-serif'],
                display: ['Fredoka One', 'cursive'],
            },
            boxShadow: {
                'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                'hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            }
        },
    },

    plugins: [forms, typography],
};
