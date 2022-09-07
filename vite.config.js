import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from "path";
import { obfuscator } from 'rollup-obfuscator';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        obfuscator({
            optionsPreset: 'medium-obfuscation',
        }),

    ],
    resolve: {
        // alias: {
        //     vue: 'vue/dist/vue.esm-bundler.js',
        //     '~alpine': path.resolve(__dirname, 'node_modules/alpinejs'),
        // },
        alias:
        {
            vue: 'vue/dist/vue.esm-bundler.js',
            '~alpine': path.resolve(__dirname, 'node_modules/alpinejs'),
        },
    },
});
