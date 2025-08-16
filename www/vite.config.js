import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'],
            refresh: true,
        }),

    ],
    server: {
        watch: {
		    // https://vitejs.dev/config/server-options.html#server-watch
            usePolling: true
        }
    },
});
