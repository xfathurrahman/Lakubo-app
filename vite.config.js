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
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
        watch: {
		    // https://vitejs.dev/config/server-options.html#server-watch
            usePolling: true
        }
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
