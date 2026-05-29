import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/pages/progress.css',
                'resources/css/pages/referrer.css',
                'resources/css/pages/brief.css',
                'resources/css/pages/testimonial.css',
                'resources/js/app.js',
                'resources/js/case-study.js',
                'resources/js/chatbot.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
