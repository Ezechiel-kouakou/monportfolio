import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // Importe le router
import './style.css'

createApp(App).use(router).mount('#app')