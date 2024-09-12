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

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            }, 
            keyframes: {
                progress: {
                  '0%': { width: '0%' },
                  '30%': { width: '50%' },  // Garis mencapai 50% lebih cepat
                  '70%': { width: '75%' },  // Garis melambat
                  '90%': { width: '85%' },  // Perlahan naik hingga 85%
                  '100%': { width: '100%' }, // Garis penuh di akhir
                },
              },
              animation: {
                progress: 'progress 10s ease-in-out',
              },
            },
    },

    plugins: [forms, typography],
};
