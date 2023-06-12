import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Open Sans"],
                serif: ['SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace', "serif"],
                body: ["Roboto", "sans-serif"],
                awesome: ["FontAwesome"],
            },
            colors: {
                'primary': '#172554',
                'secondary': '#3b82f6',
                'success': '#22c55e',
                'danger': '#ef4444',
                'dark': '#1e293b',
                'light': '#d1d5db',
              },
        },
    },

    plugins: [forms],
};
