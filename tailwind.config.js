/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/tw/**/*.{twig,js}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("daisyui")
  ],
}

