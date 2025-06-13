import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            buildDirectory: "build",
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
    ],
    build: {
        // specify the output directory for the build
        outDir: "public/build",
    },
    server: {
        cors: true,
        origin: 'https://notes.rahamatj.xyz'
    },
});
