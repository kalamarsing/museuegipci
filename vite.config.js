import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

// Configuración de Vite
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // Archivo CSS principal
                'resources/js/app.jsx',    // Archivo JS principal
                'resources/sass/back.scss',  // Archivo Sass principal para el backend (si es necesario)
                'resources/sass/front.scss'  // Archivo Sass principal para el backend (si es necesario)
            ],
            refresh: true,  // Habilita el refresco automático de la página durante el desarrollo
        }),
        react(),  // Plugin para manejar React
    ],
    
});