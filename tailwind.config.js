/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {

        'noir-piano': '#050505', 
        'primary': '#3b82f6', 
        'dark-obsidian': '#0a0a0a', 
        'card-bg': '#121212', 
      },
      boxShadow: {
        'glow-blue': '0 0 20px rgba(59, 130, 246, 0.4)',
        'modal-rise': '0 -20px 60px -15px rgba(0, 0, 0, 0.7)',
     
        'dock-brillant': '0 -10px 40px rgba(255, 255, 255, 0.05)',
      },
      borderRadius: {
        'portfolio': '2rem',
      }
    },
  },
  plugins: [],
}