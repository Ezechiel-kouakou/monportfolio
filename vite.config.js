import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

// https://vitejs.dev/config/
export default defineConfig({
  // On définit le chemin de base pour WAMP (nom de ton dossier dans www)
  // base: '/mon-portfolio/', 
  plugins: [
    vue(),
    tailwindcss(),
  ],
})