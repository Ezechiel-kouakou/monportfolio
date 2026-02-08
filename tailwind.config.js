/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Activation cruciale pour le ThemeSwitcher
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Ajout de la couleur utilisée dans ta Navbar
        'noir-piano': '#050505', 
        
        // Tes couleurs personnalisées
        'primary': '#3b82f6', // Changé en bleu (plus logique pour un 'primary')
        'dark-obsidian': '#0a0a0a', // Ajusté pour un vrai noir obsidian (le rouge était une erreur de test ?)
        'card-bg': '#121212', 
      },
      boxShadow: {
        'glow-blue': '0 0 20px rgba(59, 130, 246, 0.4)',
        'modal-rise': '0 -20px 60px -15px rgba(0, 0, 0, 0.7)',
        // Ajout de l'ombre brillante pour ton dock
        'dock-brillant': '0 -10px 40px rgba(255, 255, 255, 0.05)',
      },
      borderRadius: {
        'portfolio': '2rem',
      }
    },
  },
  plugins: [],
}