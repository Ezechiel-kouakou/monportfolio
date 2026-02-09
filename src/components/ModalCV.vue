<script setup>
import { Download, X } from "lucide-vue-next";

defineProps(["isOpen"]);
const emit = defineEmits(["close"]);

const cvPath = "/CVKOUAKOU.pdf";
</script>

<template>
  <Transition name="fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-[10000] flex items-center justify-center p-4 md:p-8"
    >
      <div
        @click="emit('close')"
        class="absolute inset-0 bg-black/60 dark:bg-black/80 backdrop-blur-md"
      ></div>

      <div
        class="relative bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-[2rem] shadow-2xl max-w-4xl w-full h-[85vh] flex flex-col overflow-hidden transition-colors duration-500"
      >
        <div
          class="p-6 border-b border-zinc-100 dark:border-white/5 flex justify-between items-center bg-zinc-50/50 dark:bg-white/5 transition-colors"
        >
          <div>
            <h2
              class="text-xl md:text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-tighter"
            >
              Curriculum Vitae
            </h2>
            <p class="text-zinc-500 dark:text-white/40 text-xs uppercase tracking-widest mt-1">
              Ezechiel Kouakou
            </p>
          </div>

          <div class="flex items-center gap-2 md:gap-4">
            <a
              :href="cvPath"
              download
              class="flex items-center gap-2 bg-zinc-900 dark:bg-white text-white dark:text-black px-4 py-2 rounded-xl font-bold text-xs hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition-all duration-300 shadow-md"
            >
              <Download :size="16" />
              <span class="hidden sm:inline">Télécharger</span>
            </a>

            <button
              @click="emit('close')"
              class="p-2 text-zinc-500 dark:text-white/50 hover:text-zinc-900 dark:hover:text-white bg-zinc-100 dark:bg-white/5 rounded-xl transition-colors"
            >
              <X :size="24" />
            </button>
          </div>
        </div>

        <div class="flex-grow bg-zinc-200 dark:bg-zinc-900 relative transition-colors">
          <iframe
            :src="cvPath"
            class="w-full h-full border-none"
            title="CV Ezechiel Kouakou"
          ></iframe>

          <div
            class="absolute inset-0 flex items-center justify-center -z-10 text-zinc-500 dark:text-white/20 italic p-10 text-center"
          >
            Affichage du PDF en cours ou non supporté par votre navigateur.
            Utilisez le bouton télécharger ci-dessus.
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(20px);
}

::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}
.dark ::-webkit-scrollbar-thumb {
  background: #333;
}
</style>