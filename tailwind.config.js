/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Http/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        colegio: {
          50: "#f7eaea",
          100: "#eec5c4",
          200: "#dc8b89",
          300: "#c6544e",
          400: "#9f2d27",
          500: "#792321",
          600: "#6E211F",
          700: "#4b1917",
          800: "#2f100e",
          900: "#170807"
        },
        highlight: {
          50: "#fbf3e7",
          100: "#f7e3c8",
          200: "#f3d4aa",
          300: "#eec48b",
          400: "#e8af6f",
          500: "#DA9C64",
          600: "#c58652",
          700: "#a06a3d",
          800: "#7c4f2a",
          900: "#57371d"
        }
      }
    },
  },
  plugins: [],
}
