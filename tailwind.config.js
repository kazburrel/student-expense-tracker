import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        colors,
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        "bg-red-500",
        "text-3xl",
        "lg:text-4xl",
        "bg-fuchsia-600",
        "bg-blue-500",
        "bg-gray-300",
        "border-dashed",
        "border-gray-900/25",
        "text-5xl",
    ],

    plugins: [forms],
};
