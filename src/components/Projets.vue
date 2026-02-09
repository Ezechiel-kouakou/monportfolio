<script setup>
import { ref } from "vue";
import { Users, Database, Code, ArrowUpRight, X } from "lucide-vue-next";
const videoSPRS = "/deploiement_sprs.mp4"; 

const isVideoModalOpen = ref(false);
const currentVideo = ref("");

const handleProjectClick = (e, link) => {
  if (link === videoSPRS) {
    e.preventDefault();
    currentVideo.value = link;
    isVideoModalOpen.value = true;
  }
};

const topProjets = [
  {
    id: 1,
    title: "SPRS | Seyrin paperless registration system",
    description: "Système d'inscription dématérialisée des membres de Seyrin.",
    technos: [
      { name: "html", icon: "https://cdn.simpleicons.org/html5/E34F26" },
      { name: "javascript", icon: "https://cdn.simpleicons.org/javascript/F7DF1E" },
      { name: "php", icon: "https://cdn.simpleicons.org/php/777BB4" },
      { name: "MySQL", icon: "https://cdn.simpleicons.org/mysql/4479A1" },
    ],
    icon: Users,
    link: "https://seyrinwebsite.infinityfreeapp.com/auth.php",
  },
  {
    id: 2,
    title: "Déploiement de SPRS sur Debian",
    description: "Infrastructure sécurisée et transfert FTP sur serveur distant.",
    technos: [
      { name: "Debian", icon: "https://cdn.simpleicons.org/debian/A81D33" },
      { name: "FileZilla", icon: "https://cdn.simpleicons.org/filezilla/EF4E34" },
      { name: "VirtualBox", icon: "https://cdn.simpleicons.org/virtualbox/183A61" },
    ],
    icon: Database,
    link: videoSPRS, 
  },
  {
    id: 3,
    title: "API REST ",
    description: "Test technique portant sur la création d'une API REST en Node.js avec Express et typescript.",
    technos: [
      { name: "Express", icon: "https://cdn.simpleicons.org/express/000000" },
      { name: "typescript", icon: "https://cdn.simpleicons.org/typescript/3178C6" },
      { name: "Node.js", icon: "https://cdn.simpleicons.org/nodedotjs/339933" },
    ],
    icon: Code,
    link: "https://github.com/Ezechiel-kouakou/ApiRest",
  },
];
</script>
<template>
  <section id="projets" class="bg-zinc-50 dark:bg-[#050505] w-full px-6 py-20 md:py-32 overflow-hidden transition-colors duration-500">
    <div class="max-w-7xl mx-auto">
      <div class="mb-12 md:mb-16 text-black dark:text-white transition-colors duration-500">
        <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter">
          Mes projets
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="projet in topProjets" :key="projet.id"
          class="flex flex-col h-full bg-white dark:bg-[#0c0c0c] rounded-[2rem] md:rounded-[2.5rem] overflow-hidden shadow-xl dark:shadow-2xl transition-all duration-500 hover:-translate-y-3 group relative border border-zinc-200 dark:border-white/5">
          
          <div class="h-48 md:h-52 bg-zinc-100 dark:bg-[#111] flex items-center justify-center relative transition-colors duration-500">
            <div class="p-5 md:p-6 bg-white dark:bg-black rounded-[1.5rem] md:rounded-[2rem] border border-zinc-200 dark:border-white/10 shadow-lg group-hover:scale-110 transition-transform duration-500">
              <component :is="projet.icon" class="w-8 h-8 md:w-10 md:h-10 text-black dark:text-white" />
            </div>
          </div>

          <div class="p-8 md:p-10 flex flex-col flex-grow bg-white dark:bg-[#0c0c0c] relative transition-colors duration-500">
            <h3 class="text-lg md:text-xl font-black text-black dark:text-white leading-tight mb-4 uppercase tracking-tight pr-10">
              {{ projet.title }}
            </h3>
            <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm mb-14 flex-grow leading-relaxed font-medium">
              {{ projet.description }}
            </p>

            <div class="flex items-center gap-4 md:gap-5 mt-auto">
              <div v-for="tech in projet.technos" :key="tech.name" class="group/tech relative">
                <img :src="tech.icon" :alt="tech.name" class="w-6 h-6 md:w-7 md:h-7 transition-transform hover:scale-125 duration-300" />
              </div>
            </div>

            <a :href="projet.link" target="_blank" @click="handleProjectClick($event, projet.link)"
              class="absolute bottom-6 right-6 md:bottom-8 md:right-8 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-black dark:bg-white text-white dark:text-black rounded-xl md:rounded-2xl hover:bg-green-900 dark:hover:bg-blue-500 transition-all duration-500 shadow-lg hover:rotate-[360deg] group/btn cursor-pointer">
              <ArrowUpRight class="w-5 h-5 md:w-6 md:h-6 group-hover/btn:scale-110" />
            </a>
          </div>
        </div>
      </div>
    </div>

    <Transition name="fade">
      <div v-if="isVideoModalOpen" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
        <div @click="isVideoModalOpen = false" class="absolute inset-0 bg-black/95 backdrop-blur-md"></div>
        <div class="relative w-full max-w-5xl aspect-video bg-black rounded-2xl md:rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
          <button @click="isVideoModalOpen = false"
            class="absolute top-4 right-4 md:top-6 md:right-6 z-50 p-2 md:p-3 bg-white/10 hover:bg-white text-white hover:text-black rounded-full transition-all duration-300">
            <X :size="20" class="md:w-6 md:h-6" />
          </button>
          <video :src="currentVideo" controls autoplay class="w-full h-full object-contain"></video>
        </div>
      </div>
    </Transition>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: scale(0.95); }
</style>