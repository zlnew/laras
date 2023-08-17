import { defineConfig } from 'vite';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import eslint from 'vite-plugin-eslint';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls }
        }),
        quasar({
            sassVariables: 'resources/css/quasar-variables.sass'
        }),
        eslint()
    ]
});
