import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // 'resources/css/theme-blue.css',
                // 'resources/css/theme-red.css',
                // 'resources/css/theme-green.css',
            ],
            refresh: true,
        }),
    ],
});
