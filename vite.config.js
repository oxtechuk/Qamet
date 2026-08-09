import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/react/main.tsx'],
            publicDirectory: 'public',
            hotFile: 'public/hot',
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        port: 5156,
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
        watch: {
            ignored: [
                '**/storage/framework/views/**',
            ],
        },
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('react') || id.includes('react-dom') || id.includes('react-router-dom')) {
                            return 'vendor';
                        }
                        if (id.includes('@tanstack/react-query')) {
                            return 'query';
                        }
                        if (id.includes('lucide-react') || id.includes('react-icons')) {
                            return 'icons';
                        }
                    }
                },
            },
        },
    },
});
