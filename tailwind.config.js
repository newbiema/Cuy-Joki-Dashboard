/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{php,js}",
            "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ['Poppins'], 
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}