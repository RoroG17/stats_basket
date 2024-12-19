import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // Assure le rafraîchissement lors des changements
        }),
        vue({
            template: { transformAssetUrls }, // Gère les URLs des assets pour Vue
        }),
        quasar({
            sassVariables: 'C:/wamp64/www/basket/stats/resources/css/quasar-variables.sass', // Spécifie le fichier des variables Sass
        }),
    ],
});
