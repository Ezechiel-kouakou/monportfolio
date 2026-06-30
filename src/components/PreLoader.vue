<template>
  <Transition name="fade-overlay">
    <div v-if="show" class="fixed inset-0 z-[10000] bg-[#060b24] flex flex-col justify-between items-center py-20 px-4 overflow-hidden touch-none">
      
      <div class="mt-20 h-10 flex items-center justify-center pointer-events-none">
        <Transition name="slide-up" mode="out-in">
          <span :key="currentText" class="text-white/40 text-sm md:text-base font-medium tracking-[0.5em] uppercase">
            {{ currentText }}
          </span>
        </Transition>
      </div>

      <div class="flex flex-col items-center">
        <i class="ph ph-spinner-gap text-blue-500 text-5xl md:text-6xl animate-sync-spin inline-block"></i>
        <i class="ph ph-spinner-gap"></i>
        <p class="mt-10 text-white/20 text-[9px] tracking-[0.5em] uppercase font-light">
          Initialisation du système
        </p>
      </div>

      <div class="flex flex-col items-center gap-2 text-center">
        <h2 class="text-white/50 text-xs font-medium tracking-[0.3em] uppercase">
          Ezechie <span class="font-black text-white">Kouakou</span>
        </h2>
        <div class="h-[1px] w-6 bg-blue-500/30"></div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue';

defineProps({
  show: Boolean
});

const currentText = ref("Welcome !");

onMounted(() => {
  setTimeout(() => {
    currentText.value = "Bienvenue !";
  }, 1400);
});
</script>

<style scoped>
.animate-sync-spin {
  display: inline-block;
  animation: sync-spin 1.2s linear infinite !important;
}

@keyframes sync-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.slide-up-enter-active, .slide-up-leave-active {
  transition: all 0.5s ease;
}
.slide-up-enter-from { opacity: 0; transform: translateY(5px); }
.slide-up-leave-to { opacity: 0; transform: translateY(-5px); }

.fade-overlay-leave-active {
  transition: opacity 0.8s ease;
}
.fade-overlay-leave-to {
  opacity: 0;
}
</style>