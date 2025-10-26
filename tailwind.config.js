import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#f3ebf8",
                    100: "#e7eaf6",
                    200: "#dddfe7",
                    500: "#2725a9",
                    600: "#1f1d87",
                    700: "#171565",
                    800: "#0f0d43",
                    900: "#070521",
                },
                neutral: {
                    50: "#f9f5f2",
                    100: "#f4f5f7",
                    200: "#dddfe7",
                    300: "#4f5561",
                    400: "#606266",
                    900: "#0c0d10",
                },
                accent: {
                    light: "#f3ebf8",
                    blue: "#e7eaf6",
                },
            },
        },
    },

    plugins: [forms],
};
