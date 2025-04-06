import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls },
        }),
        quasar({
            sassVariables: 'C:/wamp64/www/basket/stats/resources/css/quasar-variables.sass',
        }),
    ],
    resolve: {
        alias: {
            jspdf: 'jspdf/dist/jspdf.umd.js', // Assure la compatibilité avec jsPDF
        },
    },
    build: {
        rollupOptions: {
            external: ['jspdf'], // Permet de traiter jsPDF comme une dépendance externe
        },
    },
});
