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
                sans: ["Gilmer", ...defaultTheme.fontFamily.sans],
                heading: ["Aurora", ...defaultTheme.fontFamily.serif],
            },
            colors: {
                primary: {
                    50: "#fef9ec",  // Or très clair
                    100: "#fde788", // Or clair (haut gradient) 
                    200: "#fcd670", // Or clair-moyen
                    500: "#e8bf5e", // Or moyen (centre gradient)  PRINCIPALE
                    600: "#d4a947", // Or moyen-foncé
                    700: "#b88a30", // Or foncé-moyen
                    800: "#a05e18", // Or foncé (bas gradient) 
                    900: "#8c581c", // Or très foncé
                },
                neutral: {
                    50: "#f9f5f2",  // Beige neutre (conservé)
                    100: "#f0f0f0", // Gris très clair
                    200: "#d0d0d0", // Gris clair (bordures)
                    300: "#40464b", // Gris principal 
                    400: "#40464b", // Gris principal 
                    900: "#000000", // Noir 
                },
                accent: {
                    light: "#fde788", // Or clair
                    blue: "#fde788",  // Or clair (remplace l'ancien bleu)
                },
            },
        },
    },

    plugins: [forms],
};
