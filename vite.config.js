import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

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
            // "@/images": "/resources/images",
            // "@/components": "/resources/js/Components",
            // "@/*": "/resources/js/*",
            "@/images": path.resolve(__dirname, "resources/images"),
            "@/components": path.resolve(__dirname, "resources/js/Components"),
            "@/composables": path.resolve(
                __dirname,
                "resources/js/Composables"
            ),
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
});
