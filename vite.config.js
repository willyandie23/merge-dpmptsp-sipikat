import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        rollupOptions: {
            output: {
                assetFileNames: 'css/[name].min.css',
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
            },
        },
    },

    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/icons.scss',
                'resources/scss/bootstrap.scss',
                'resources/js/app.js',
                'resources/js/ckeditor.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
    targets: [
        // Copy isi folder (bukan folder itu sendiri)
        { src: 'resources/fonts/*', dest: 'fonts' },
        { src: 'resources/images/*', dest: 'images' },
        { src: 'resources/libs/*', dest: 'libs' },

        // Custom path untuk template lama (penting untuk icon)
        { src: 'resources/fonts/*', dest: 'css/custom/plugins/fonts' },
        { src: 'resources/images/*', dest: 'css/custom/images' },

        // Subfolder libs yang sering dipakai
        { src: 'resources/libs/admin-resources', dest: 'libs/admin-resources' },
        { src: 'resources/libs/apexcharts', dest: 'libs/apexcharts' },
    ]
}),
    ],

    resolve: {
        alias: {
            '$': 'jquery',
            'jQuery': 'jquery',
        },
    },

    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import'],
            },
        },
    },
});