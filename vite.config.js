import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        port: 3000 // ubah port menjadi 3000 atau port yang diinginkan
    },
    /*resolve: {
        alias: {
            '@fortawesome/fontawesome-free/css/all.css': '@fortawesome/fontawesome-free/css/all.min.css'
        }
    },*/
    build: {
        chunkSizeWarningLimit: 100000000,
    },
});
