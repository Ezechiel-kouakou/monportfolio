<template>
  <div class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6]">
    
    <div class="bg-white border-b border-gray-200 shadow-sm overflow-hidden">
      <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row items-stretch">
        <div class="flex-1 px-4 md:px-8 py-16 md:py-24 space-y-6 self-center">
          <div class="inline-flex items-center gap-2 px-3 py-4 bg-transparent text-[#060b24] rounded-xs border-blue-100 text-[15px] md:text-[11px] font-light capitalize tracking-wider">
            <i class="ph ph-stack text-[25px] text-blue-400"></i> Ezechiel Kouakou Media Hub
          </div>
          <div class="w-50 h-2 bg-gradient-to-r from-[#d2d9fc] to-transparent rounded-full"></div>
          <p class="text-[12px] text-gray-800 text-center font-medium bg-gray-100/50 p-3 rounded-xl">
            <i class="ph ph-warning-circle"></i> 
            Note : Pour visionner les vidéos sur Google Chrome, veuillez autoriser l'accès au réseau privé ou utiliser Edge/Safari.
          </p>
          <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-[1.1] tracking-tight">
            Médiathèque Technique <br>
          </h1>
          <p class="text-sm md:text-base text-gray-500 max-w-xl leading-relaxed">
            « Créé par les étudiants, fait pour les étudiants. » <br>
            Découvrez mes démonstrations de projets et présentations professionnelles, 
            hébergées sur mon infrastructure hybride Penguin(Linux Crostini) & Azure.
          </p>
          <div class="flex items-center gap-4 pt-2">
            <router-link to="/tableau-synthese" class="px-6 py-2.5 bg-[#060b24] text-white text-xs font-bold rounded-xs hover:bg-opacity-90 transition-all shadow-md flex items-center gap-2">
              <i class="ph ph-layout"></i> Voir les compétences
            </router-link>
          </div>
        </div>

        <div class="flex-1 relative min-h-[300px] md:min-h-full">
          <img src="../assets/mon-homelab.png" alt="Illustration Mediatheque" class="absolute inset-0 w-full h-full object-cover object-center" />
          <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent pointer-events-none md:hidden"></div>
        </div>
      </div>
    </div>

    <main class="max-w-[1400px] mx-auto p-4 md:p-8 mt-4">
      <div class="maintenance-container">
    <div class="maintenance-card">
      <div class="icon-gear">
      <i class="ph ph-gear"></i> 
      </div>
      <h1>Site en maintenance</h1>
      <p>En raison d'une maintenance qui touche l'infrastructure système de cette section du site, celui-ci est temporairement indisponible jusqu'au 01/09/2026.</p>
      <p>Pour tout renseignement, veuillez contacter l'administrateur du site à l'adresse suivante : contact@ezechielkouakou.fr</p>
      
      <div class="countdown">
        <span v-if="isOver">Retour imminent, merci de votre patience.</span>
        <template v-else>
          <span>Retour estimé dans :</span>
          <strong>{{ days }}jrs {{ pad(hours) }}h {{ pad(minutes) }}m {{ pad(seconds) }}s</strong>
        </template>
      </div>
    </div>
  </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Date cible réelle et fixe : 01/09/2026 à 00:00, heure locale du serveur/visiteur.
// C'est cette constante qu'il faut modifier pour changer la date de retour.
const TARGET_DATE = new Date('2026-09-01T00:00:00')

const days = ref(0)
const hours = ref(0)
const minutes = ref(0)
const seconds = ref(0)
const isOver = ref(false)

let timer = null

const pad = (n) => String(n).padStart(2, '0')

const updateTimer = () => {
  // Recalcul à partir de l'heure réelle du visiteur à chaque tick,
  // donc toujours exact peu importe quand la page est ouverte,
  // combien de temps l'onglet reste ouvert, ou le fuseau horaire.
  const now = new Date()
  const diffMs = TARGET_DATE.getTime() - now.getTime()

  if (diffMs <= 0) {
    isOver.value = true
    days.value = 0
    hours.value = 0
    minutes.value = 0
    seconds.value = 0
    clearInterval(timer)
    return
  }

  const diffSeconds = Math.floor(diffMs / 1000)

  days.value = Math.floor(diffSeconds / 86400)
  hours.value = Math.floor((diffSeconds % 86400) / 3600)
  minutes.value = Math.floor((diffSeconds % 3600) / 60)
  seconds.value = diffSeconds % 60
}

onMounted(() => {
  updateTimer()
  timer = setInterval(updateTimer, 1000)
})

onUnmounted(() => {
  clearInterval(timer)
})
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");
.maintenance-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 70vh;
  background-color:transparent !important;
  font-family: Arial, sans-serif;
}

.maintenance-card {
  text-align: center;
  padding: 40px;
  background: white;
  border-radius: 2px;
  border : 1px solid #222121;
  /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); */
  max-width: 1200px;
}

.icon-gear {
  font-size: 50px;
  color:#1097b9;
  margin-bottom: 20px;
  animation: spin 4s linear infinite;
}

h1 {
  color: #333;
  margin-bottom: 10px;
}

p {
  color: #666;
  font-size: 16px;
  margin-bottom: 10px;
  font-weight: 400;
  font-family:Verdana, Geneva, Tahoma, sans-serif;
}

.countdown {
  background: transparent !important;
  padding: 12px;
  border-radius: 8px;
  font-size: 14px;
  font-family:Verdana, Geneva, Tahoma, sans-serif;
  font-weight:bold;
  color: #444;
}

.countdown strong {
  display: block;
  color: #1097b9;
  font-size: 18px;
  font-weight: light;
  margin-top: 4px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>