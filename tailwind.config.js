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
                primary: 'var(--bg-primary)',
                card: 'var(--bg-card)',
                heading: 'var(--text-heading)',
                body: 'var(--text-body)',
                accent: 'var(--accent-color)',
                badge: 'var(--bg-badge)',
            },
            animation: {
                'float-slow': 'float 6s ease-in-out infinite',
                'spin-slow': 'spin 20s linear infinite',
                'spin-reverse': 'spin-reverse 25s linear infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                'spin-reverse': {
                    from: { transform: 'rotate(360deg)' },
                    to: { transform: 'rotate(0deg)' },
                }
            }
        },
    },

    plugins: [forms],
};
