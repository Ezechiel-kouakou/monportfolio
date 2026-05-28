<script setup>
import { onMounted, ref, watch } from "vue";
import maPhoto from "../assets/photo_ezechiel.jpeg";
import { Linkedin, Github } from "lucide-vue-next";

// États pour le chargement et la visibilité
const isVisible = ref(false);
const isAppLoading = ref(true);
const currentText = ref("Welcome !");

// Bloquer le scroll du body tant que le loader est là
watch(isAppLoading, (loading) => {
  document.body.style.overflow = loading ? 'hidden' : '';
}, { immediate: true });

onMounted(() => {
  // Séquence de texte du loader
  setTimeout(() => {
    currentText.value = "Bienvenue !";
  }, 1800);

  // Fin du chargement
  setTimeout(() => {
    isAppLoading.value = false;
    // Déclenchement des animations du Hero 400ms après la disparition du loader
    setTimeout(() => {
      isVisible.value = true;
    }, 400); 
  }, 3800);
});
</script>

<template>
  <div class="relative w-full min-h-screen">
    
    <Transition name="fade-overlay">
      <div v-if="isAppLoading" class="fixed inset-0 z-[9999] bg-[#0f0f0f] flex flex-col justify-between items-center py-20 px-4 overflow-hidden touch-none">
        
        <div class="mt-20 h-10 flex items-center justify-center pointer-events-none">
          <Transition name="slide-up" mode="out-in">
            <span :key="currentText" class="text-white/100 text-3xl md:text-base font-bold tracking-[0.0em] capitalize">
              {{ currentText }}
            </span>
          </Transition>
        </div>

        <div class="flex flex-col items-center">
          <i class="ph ph-arrows-counter-clockwise text-white/100 text-5xl md:text-6xl animate-sync-spin inline-block"></i>
          <p class="mt-10 text-white/20 text-[9px] tracking-[0.5em] uppercase font-light">
             <!-- Donne moi une seconde -->
          </p>
        </div>

        <div class="flex flex-col items-center gap-2">
          <h2 class="text-white/100 text-2xl  font-light tracking-[0.0em] lowercase">
             Ezechiel <span class="font-black text-white">Kouakou</span>
          </h2>
          <div class="h-[1px] w-6 bg-white/100"></div>
        </div>
      </div>
    </Transition>

    <section
      class="bg-white dark:bg-[#050505] min-h-screen w-full relative flex items-center justify-center overflow-hidden px-6 py-20 md:py-0 transition-colors duration-500"
    >
      <div class="z-10 max-w-7xl w-full flex flex-col md:flex-row items-center gap-10 md:gap-16">
        
        <div
          class="flex-1 flex justify-center md:justify-start transition-all duration-1000 ease-[cubic-bezier(0.23,1,0.32,1)]"
          :class="isVisible ? 'translate-x-0 opacity-100' : 'md:-translate-x-24 -translate-y-12 opacity-0'"
        >
          <div class="relative group">
            <div class="relative z-10 w-56 h-56 md:w-96 md:h-96 border-0 border-white overflow-hidden rounded-2xl shadow-2xl">
              <img
                :src="maPhoto"
                alt="Ezechiel"
                class="w-full h-full object-cover object-top grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-105"
              />
            </div>

            <div class="absolute -top-3 -left-3 md:-top-4 md:-left-4 bg-zinc-900 dark:bg-white text-white dark:text-black px-3 py-1 md:px-4 md:py-2 font-bold uppercase text-[10px] md:text-xs tracking-widest skew-x-[-12deg] z-20 shadow-lg transition-colors">
              Étudiant
            </div>
          </div>
        </div>

        <div
          class="flex-1 text-center md:text-left transition-all duration-1000 ease-[cubic-bezier(0.23,1,0.32,1)] delay-150"
          :class="isVisible ? 'translate-x-0 opacity-100' : 'md:translate-x-24 translate-y-12 opacity-0'"
        >
          <h1 class="text-zinc-900 dark:text-white text-5xl md:text-8xl font-black tracking-tighter mb-4 leading-none font-display transition-colors">
            Ezechiel
          </h1>

          <div class="h-1 w-16 md:w-20 bg-zinc-900 dark:bg-white mb-6 md:mb-8 mx-auto md:mx-0 transition-colors"></div>

          <p class="text-zinc-600 dark:text-white/80 text-base md:text-2xl capitalize tracking-[0.1em] md:tracking-[0.2em] font-light leading-relaxed transition-colors">
            Étudiant en 1ère année de BTS SIO,<br />
            <span class="font-bold text-zinc-900 dark:text-white">Développement Web & Réseau.</span>
          </p>

          <div class="mt-6 md:mt-8 flex justify-center md:justify-start gap-6">
            <a href="https://www.linkedin.com/in/ezechielk" target="_blank" class="text-zinc-400 dark:text-white/30 hover:text-blue-500 transition-all duration-300">
              <Linkedin :size="26" class="md:w-[30px] md:h-[30px]" stroke-width="1.5" />
            </a>
            <a href="https://github.com/Ezechiel-kouakou" target="_blank" class="text-zinc-400 dark:text-white/30 hover:text-zinc-900 dark:hover:text-white transition-all duration-300">
              <Github :size="26" class="md:w-[30px] md:h-[30px]" stroke-width="1.5" />
            </a>
          </div>

          <div class="mt-8 md:mt-10 flex flex-wrap justify-around md:justify-start gap-4 transition-all duration-300">
            <slot name="actions"></slot> <router-link to="/tableau-synthese" 
              class="flex items-center gap-2 text-xs md:text-sm font-bold text-[#060b24] bg-white border border-gray-200 px-5 py-2.5 rounded-lg hover:border-[#060b24] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shadow-sm">
              <i class="ph ph-layout text-lg"></i>
              <span>Tableau de synthèse</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
/* Animation de rotation de l'icône */
.animate-sync-spin {
  display: inline-block;
  animation: sync-spin 1.2s linear infinite !important;
}
@keyframes sync-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Transitions du texte loader */
.slide-up-enter-active, .slide-up-leave-active {
  transition: all 0.5s ease;
}
.slide-up-enter-from { opacity: 0; transform: translateY(5px); }
.slide-up-leave-to { opacity: 0; transform: translateY(-5px); }

/* Transition de sortie du loader */
.fade-overlay-leave-active {
  transition: opacity 0.8s ease;
}
.fade-overlay-leave-to {
  opacity: 0;
}

/* Import Phosphor */
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
</style>