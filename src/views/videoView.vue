<template>
  <div class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6]">
    
    <div class="bg-white border-b border-gray-200 shadow-sm overflow-hidden">
      <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row items-stretch">
        <div class="flex-1 px-4 md:px-8 py-16 md:py-24 space-y-6 self-center">
          <div class="inline-flex items-center gap-2 px-3 py-4 bg-transparent text-[#060b24] rounded-xs border-blue-100 text-[15px] md:text-[11px] font-light capitalize tracking-wider">
            <i class="ph ph-stack text-[25px] text-blue-400"></i> Ezechiel Kouakou Media Hub
          </div>
          <div class="w-16 h-1 bg-gradient-to-r from-[#060b24] to-transparent rounded-full"></div>
          <p class="text-[11px] text-amber-800 text-center font-medium">
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
          <img src="../assets/image_host_self.jpg" alt="Illustration Mediatheque" class="absolute inset-0 w-full h-full object-cover object-center" />
          <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent pointer-events-none md:hidden"></div>
        </div>
      </div>
    </div>

    <main class="max-w-[1400px] mx-auto p-4 md:p-8 mt-4">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-9 space-y-8">

          <!-- SKELETON : Vidéo présentation -->
          <div v-if="loading" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden animate-pulse">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
              <div class="h-5 w-5 bg-gray-200 rounded"></div>
              <div class="h-5 w-48 bg-gray-200 rounded"></div>
            </div>
            <div class="p-6">
              <div class="h-4 w-32 bg-gray-200 rounded mb-4"></div>
              <div class="aspect-video bg-gray-200 rounded-xs"></div>
              <div class="mt-6 space-y-2">
                <div class="h-6 w-56 bg-gray-200 rounded"></div>
                <div class="h-4 w-full bg-gray-100 rounded"></div>
                <div class="h-4 w-3/4 bg-gray-100 rounded"></div>
                <div class="h-3 w-24 bg-gray-100 rounded mt-2"></div>
              </div>
            </div>
          </div>

          <!-- Vidéo présentation réelle -->
          <div v-else class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
              <i class="ph ph-identification-card text-[#060b24] text-xl"></i>
              <h3 class="font-bold text-gray-800">Présentation Professionnelle</h3>
            </div>
            <div class="p-6">
              <div v-if="presentationVideo">
                <div class="mb-4">
                  <span v-if="presentationVideo.mode_suppression === '15j'"
                        :class="presentationVideo.jours_restants <= 3 ? 'text-red-800 font-light animate-pulse' : 'text-amber-700'" 
                        class="text-[10px] flex items-center gap-1.5 bg-transparent px-3 py-1 w-fit">
                    <i class="ph-fill ph-hourglass-high"></i>
                    Suppression automatique dans {{ presentationVideo.jours_restants }} jours
                  </span>
                  <span v-else class="text-blue-700 text-[10px] flex items-center gap-1.5 bg-blue-50/50 px-3 py-1 rounded-xs w-fit">
                    <i class="ph-fill ph-shield-check"></i>
                    Conservation permanente
                  </span>
                </div>
                <div class="aspect-video bg-black rounded-xs overflow-hidden border border-gray-200 shadow-inner">
                  <video :key="presentationVideo.nom_fichier" controls class="w-full h-full" crossorigin="anonymous">
                    <source :src="presentationVideo.nom_fichier" type="video/mp4">
                  </video>
                </div>
                <div class="mt-6">
                  <h2 class="text-xl font-black text-gray-900 capitalize">{{ presentationVideo.titre }}</h2>
                  <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ presentationVideo.description }}</p>
                  <p class="text-[8px] text-gray-400 mt-3 lowercase tracking-wide">
                    <i class="ph ph-calendar-blank"></i> publiée le {{ new Date(presentationVideo.date_creation).toLocaleDateString('fr-FR') }}
                  </p>
                </div>
              </div>
              
              <div v-else class="py-24 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                  <i class="ph ph-hourglass-high text-2xl text-amber-500"></i>
                </div>
                <h4 class="text-gray-900 font-bold text-base">La vidéo n'a pas encore été rajoutée par son propriétaire.</h4>
                <div class="mt-4 px-5 py-2 bg-[#f0f7ff] border border-blue-100 rounded-xs text-[#060b24] text-xs font-light">
                  Date d'ajout prévue : jusqu'au 05/05/2026
                </div>
                <p class="text-[10px] text-gray-400 mt-4 lowercase italic tracking-tight">
                  <i class="ph ph-info"></i> merci de revenir de temps en temps visiter afin de rester informer.
                </p>
              </div>
            </div>
          </div>

          <!-- SKELETON : Supports techniques -->
          <div v-if="loading" class="space-y-4">
            <div class="h-5 w-40 bg-gray-200 rounded animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div v-for="i in 2" :key="i" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden animate-pulse">
                <div class="aspect-video bg-gray-200"></div>
                <div class="p-4 space-y-2">
                  <div class="h-4 w-3/4 bg-gray-200 rounded"></div>
                  <div class="h-3 w-full bg-gray-100 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                  <div class="flex justify-between mt-4 pt-3 border-t border-gray-50">
                    <div class="h-3 w-20 bg-gray-100 rounded"></div>
                    <div class="h-3 w-16 bg-gray-100 rounded"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Supports techniques réels -->
          <div v-else class="space-y-4">
            <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
              <i class="ph ph-code text-[#060b24]"></i> Supports Techniques
            </h3>
            <div v-if="technicalVideos.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div v-for="video in technicalVideos" :key="video.id" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
                <div class="aspect-video bg-black">
                  <video :key="video.nom_fichier" controls preload="metadata" class="w-full h-full" crossorigin="anonymous">
                    <source :src="video.nom_fichier" type="video/mp4">
                  </video>
                </div>
                <div class="p-4">
                  <h4 class="font-bold text-gray-900 text-xs lowercase">{{ video.titre }}</h4>
                  <p class="text-[10px] text-gray-500 mt-2 leading-relaxed italic">{{ video.description }}</p>
                  <div class="mt-4 flex items-center justify-between border-t border-gray-50 pt-3">
                    <p class="text-[9px] text-gray-400 uppercase tracking-wide">
                      <i class="ph ph-calendar-blank"></i> {{ new Date(video.date_creation).toLocaleDateString('fr-FR') }}
                    </p>
                    <span v-if="video.mode_suppression === '15j'" 
                          :class="video.jours_restants <= 3 ? 'text-red-800 font-light' : 'text-gray-500'" 
                          class="text-[10px] flex items-center gap-1 uppercase tracking-tighter">
                      <i class="ph-fill ph-clock-countdown"></i> J-{{ video.jours_restants }}
                    </span>
                    <span v-else class="text-[9px] text-green-600 font-medium uppercase tracking-tighter">
                      <i class="ph-fill ph-infinity"></i> Permanent
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="p-12 border border-dashed border-gray-200 rounded-xs text-center opacity-40">
              <i class="ph ph-video-slash text-4xl mb-2"></i>
              <p class="text-[10px] font-light italic">Aucun support technique n'est disponible pour le moment.</p>
            </div>
          </div>

        </div>

        <div class="lg:col-span-3">

          <div v-if="loading" class="bg-white rounded-xs border border-gray-200 shadow-sm p-5 sticky top-8 animate-pulse">
            <div class="h-4 w-28 bg-gray-200 rounded mb-4"></div>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 bg-gray-200 rounded"></div>
                <div class="space-y-1 flex-1">
                  <div class="h-3 w-full bg-gray-200 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 bg-gray-200 rounded"></div>
                <div class="space-y-1 flex-1">
                  <div class="h-3 w-full bg-gray-200 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                </div>
              </div>
              <hr class="border-gray-100">
              <div class="h-3 w-full bg-gray-100 rounded"></div>
              <div class="h-3 w-4/5 bg-gray-100 rounded"></div>
            </div>
          </div>

          <!-- Sidebar réelle -->
          <div v-else class="bg-white rounded-xs border border-gray-200 shadow-sm p-5 sticky top-8">
            <h4 class="text-[11px] font-black text-[#060b24] uppercase tracking-widest mb-4">Architecture</h4>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <i class="ph ph-server text-xl text-blue-600"></i>
                <p class="text-[10px] text-gray-600 leading-tight">Stockage source : <br><b class="text-gray-900">Penguin (Local)</b></p>
              </div>
              <div class="flex items-start gap-3">
                <i class="ph ph-cloud-check text-xl text-green-600"></i>
                <p class="text-[10px] text-gray-600 leading-tight">Diffusion : <br><b class="text-gray-900">Tailscale Funnel</b></p>
              </div>
              <hr class="border-gray-100">
              <p class="text-[9px] text-gray-400 italic leading-relaxed">
                Le streaming est opéré via un tunnel sécurisé Tailscale Funnel, directement depuis mon serveur local Penguin.
              </p>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

const videos = ref([]);
const loading = ref(true);

const fetchData = async () => {
  loading.value = true;
  try {
    const response = await fetch('https://www.ezechielkouakou.fr/api_proxy.php');
    const data = await response.json();
    if (data.success) {
      videos.value = data.videos || [];
    }
  } catch (e) {
    // silencieux en production
  } finally {
    setTimeout(() => { loading.value = false; }, 1000);
  }
};

const presentationVideo = computed(() => 
  videos.value.find(v => v.type_video === 'presentation')
);

const technicalVideos = computed(() => 
  videos.value.filter(v => v.type_video === 'technique')
);

onMounted(fetchData);
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");

.min-h-screen {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}

video {
  object-fit: contain;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}

.animate-pulse {
  animation: pulse 1.5s ease-in-out infinite;
}
</style>