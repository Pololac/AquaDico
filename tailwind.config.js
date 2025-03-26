/** @type {import('tailwindcss').Config} */
const path = require('path');

module.exports = {
    content: [
      "./templates/**/*.html.twig",
      "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
      "./assets/**/*.js",
    ],
    darkMode: false,
    theme: {
      extend: {
        backgroundImage: {
        },
        colors: {
          }
      },
    },
    plugins: [],

  }
  