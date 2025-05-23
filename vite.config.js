import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// This is a test comment to trigger a new deployment

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
