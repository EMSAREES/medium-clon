import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                // Fuente por defecto para toda la UI (botones, menús, formularios).
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                // Fuente para títulos y contenido de artículos.
                serif: ['Fraunces', ...defaultTheme.fontFamily.serif],
            },

            colors: {
                // Paleta inspirada en Medium: negro casi puro para texto,
                // gris cálido para texto secundario, y un verde como
                // color de acento (en vez del índigo por defecto de Breeze).
                ink: {
                    DEFAULT: '#1a1a1a',   // texto principal
                    light: '#6b6b6b',     // texto secundario / metadatos
                    faint: '#e5e5e5',     // bordes sutiles
                },
                accent: {
                    DEFAULT: '#1a8917',   // verde Medium, para links y botones primarios
                    dark: '#0f730c',
                },
            },
        },
    },

    plugins: [forms, typography],
};
