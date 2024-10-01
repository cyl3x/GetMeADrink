import { fileURLToPath, URL } from 'node:url';

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import vueDevTools from 'vite-plugin-vue-devtools';
import legacy from '@vitejs/plugin-legacy';

// https://vitejs.dev/config/
export default defineConfig(({ mode }) => ({
    plugins: [
        vue(),
        vueDevTools(),
        legacy({
            // https://browsersl.ist
            modernTargets: 'since 2020-01-01, not dead',
            modernPolyfills: true,
            renderLegacyChunks: false,
        }),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./frontend', import.meta.url)),
        },
    },
    build: {
        outDir: './public/frontend',
        emptyOutDir: true,
        copyPublicDir: false,
        sourcemap: mode === 'development',
        rollupOptions: {
            input: '/frontend/main.ts',
            output: {
                entryFileNames: 'assets/[name].js',
                assetFileNames: 'assets/[name].[ext]',
            },
        },
    },
    server: {
        strictPort: true,
        port: Number(process.env.VITE_PORT) || 5173,
        fs: {
            allow: ['frontend', 'node_modules'],
        },
    },
}));
