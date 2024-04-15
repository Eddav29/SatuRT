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
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "white-snow": "#FFFAFA",
                "soft-snow": "#F2F1F4",
                "green-light": "#AFFF49",
                "azure-blue": "#3384FF",
                "blue-gray": "#E8F1FF",
                "navy-night": "#0B1215",
            },
        },
    },

    plugins: [forms],
};
