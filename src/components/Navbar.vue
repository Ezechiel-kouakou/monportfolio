<template>
  <nav
    :style="navStyle"
    :class="[
      'fixed left-0 w-full z-[9999] pointer-events-auto transition-all duration-700 ease-in-out',
      isScrolled ? 'px-0' : 'px-4 md:px-6 pt-4 md:pt-6',
    ]"
  >
    <div
      :class="[
        'mx-auto flex items-center transition-all duration-500 relative',
        isScrolled
          ? 'bg-white dark:bg-[#050505] w-full justify-around py-4 md:py-6 border-t border-zinc-200 dark:border-white rounded-t-[2.5rem] shadow-lg dark:shadow-dock-brillant pb-[calc(1rem+env(safe-area-inset-bottom))]'
          : 'max-w-7xl justify-center p-3 md:p-4 bg-white/90 dark:bg-[#050505]/40 border-x-2 border-b-2 border-t-0 border-zinc-200 dark:border-white rounded-b-2xl backdrop-blur-md',
      ]"
    >
      <div
        :class="[
          'flex items-center transition-all duration-500',
          isScrolled ? 'w-full justify-evenly' : 'gap-4 md:gap-12 px-2 md:px-4',
        ]"
      >
        <a
          v-for="link in links"
          :key="link.id"
          @click.prevent="scrollTo(link.id)"
          :class="[
            'cursor-pointer transition-all duration-300 flex items-center justify-center',
            'text-black dark:text-white',
            isScrolled
              ? 'nav-icon-dock'
              : 'nav-link-top font-light uppercase tracking-[0.2em] md:tracking-[0.2em] text-[10px] md:text-xs',
            activeSection === link.id
              ? 'active opacity-100'
              : 'opacity-40 hover:opacity-100',
          ]"
        >
          <span class="flex items-center justify-center">
            <component
              :is="link.icon"
              :size="isScrolled ? (activeSection === link.id ? 24 : 20) : 20"
              class="md:w-[28px] md:h-[28px]"
              :stroke-width="activeSection === link.id ? 1.5 : 1"
            />
          </span>

          <span v-if="!isScrolled" class="hidden md:block ml-2 font-display">
            {{ link.label }}
          </span>
        </a>

        <router-link
          to="/videos"
          :class="[
            'cursor-pointer transition-all duration-300 flex items-center justify-center',
            'text-black dark:text-white',
            isScrolled
              ? 'nav-icon-dock'
              : 'nav-link-top font-light uppercase tracking-[0.1em] md:tracking-[0.2em] text-[10px] md:text-xs opacity-70 hover:opacity-100',
          ]"
        >
          <span class="flex items-center justify-center">
            <PlayCircle
              :size="isScrolled ? 24 : 20"
              class="md:w-[28px] md:h-[28px]"
              :stroke-width="1.5"
            />
          </span>
          <span v-if="!isScrolled" class="hidden md:block ml-2 font-display">
            Médiathèques
          </span>
        </router-link>
      </div>

      <div v-if="!isScrolled" class="absolute right-4 md:right-8">
        <ThemeSwitcher />
      </div>
    </div>
  </nav>
</template>

<script setup>
import ThemeSwitcher from './ThemeSwitcher.vue'
import { ref, computed, onMounted, onUnmounted } from "vue";
import { 
  PhHouse, 
  PhBriefcase, 
  PhFolderOpen, 
  PhEnvelopeSimple, 
  PhPlayCircle 
} from "@phosphor-icons/vue";

const emit = defineEmits(["open-contact"]);
const isScrolled = ref(false);
const activeSection = ref("accueil");

const links = [
  { id: "accueil", label: "Accueil", icon: PhHouse },
  { id: "experiences", label: "Expériences", icon: PhBriefcase },
  { id: "projets", label: "Projets", icon: PhFolderOpen },
  { id: "contact", label: "Contact", icon: PhEnvelopeSimple },
  { id: "videos", label: "Vidéos", icon: PhPlayCircle }
];

const navStyle = computed(() => {
  return isScrolled.value ? { bottom: "0", top: "auto" } : { top: "0", bottom: "auto" };
});

const handleScroll = () => { isScrolled.value = window.scrollY > 120; };

const scrollTo = (id) => {
  if (id === "contact") { emit("open-contact"); return; }
  const el = document.getElementById(id);
  if (el) {
    const offset = window.innerWidth < 768 ? 20 : isScrolled.value ? 0 : 100;
    window.scrollTo({ top: el.offsetTop - offset, behavior: "smooth" });
  }
};

onMounted(() => {
  window.addEventListener("scroll", handleScroll);
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) activeSection.value = entry.target.id;
      });
    }, { threshold: 0.4 }
  );
  document.querySelectorAll("section[id]").forEach((s) => observer.observe(s));
});

onUnmounted(() => window.removeEventListener("scroll", handleScroll));
</script>

<style scoped>
.bg-noir-piano { padding-bottom: env(safe-area-inset-bottom); }
.nav-link-top { position: relative; display: inline-flex; align-items: center; }
.nav-link-top::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 50%;
  width: 0;
  height: 3px;
  background: currentColor;
  transform: translateX(-50%);
  transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
@media (min-width: 768px) { .nav-link-top::after { bottom: -24px; height: 4px; } }
.nav-link-top.active::after { width: 100%; }
.nav-icon-dock.active { transform: translateY(-3px); }
a, .router-link-active { -webkit-tap-highlight-color: transparent; }
</style>