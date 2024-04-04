/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js}"],
  theme: {
    extend: {
      backgroundColor: {
        "custom-orange": "#e2a011",
      },
      colors: {
        "custom-orange": "#e2a011",
      },
      aspectRatio: {
        "4/5": "4 / 5",
        "5/4": "5 / 4",
      },
      screens: {
        sm: "480px",
        md: "768px",
        lg: "976px",
        xl: "1440px",
      },
    },
  },
  plugins: [],
};
