/** @type {import('tailwindcss').Config} */
const path = require('path');

module.exports = {
    content: [
      "./templates/**/*.html.twig",
      "./assets/**/*.js",
      "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    ],
    darkMode: 'class',
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
  