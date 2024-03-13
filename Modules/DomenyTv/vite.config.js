import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-domenytv',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            output: {
                copy: [
                    { src: __dirname + '/soap.wdl.xml', dest: '../../public/modules/domenytv' }
                ]
            }
        }
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-domenytv',
            input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
});

//export const paths = [
//    'Modules/$STUDLY_NAME$/resources/assets/sass/app.scss',
//    'Modules/$STUDLY_NAME$/resources/assets/js/app.js',
//];
