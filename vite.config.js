import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0",
    },
    resolve: {
        alias: {
            "@/images": "/resources/images",
            "@/components": "/resources/js/Components",
            "@/*": "/resources/js/*",
        },
    },
});
