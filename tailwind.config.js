import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.css',
    ],

    theme: {
        extend: {},
    },

    plugins: [forms, typography, require('@tailwindcss/aspect-ratio')],
};