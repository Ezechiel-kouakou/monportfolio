<template>
  <Transition name="slide-up">
    <div v-if="isOpen" class="fixed inset-0 z-[10000] flex items-end justify-center">
      <div @click="$emit('close')" class="absolute inset-0 bg-black/80 backdrop-blur-xl"></div>

      <div class="relative w-full bg-white dark:bg-[#000000] border-t border-zinc-200 dark:border-white/10 rounded-t-[3rem] h-[80vh] md:h-[85vh] shadow-2xl overflow-hidden transition-colors duration-500">
        
        <div @click="$emit('close')"
          class="absolute top-6 left-1/2 -translate-x-1/2 w-16 h-1.5 bg-zinc-200 dark:bg-zinc-800 rounded-full cursor-pointer hover:bg-zinc-400 dark:hover:bg-zinc-600 transition-colors z-10">
        </div>

        <div class="max-w-5xl mx-auto p-8 pt-16 h-full flex flex-col items-center justify-center text-center">
          
          <div v-if="loading" class="flex flex-col items-center gap-4">
            <span class="w-12 h-12 border-4 border-zinc-200 border-t-black dark:border-zinc-800 dark:border-t-white rounded-full animate-spin"></span>
            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Vérification du serveur...</p>
          </div>

          <div v-else class="max-w-md animate-in fade-in zoom-in duration-500">
            <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg shadow-red-500/20">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>

            <h3 class="text-3xl font-bold text-zinc-900 dark:text-white mb-6 tracking-tighter">Oups !</h3>
            
            <p class="text-zinc-600 dark:text-zinc-400 font-medium leading-relaxed mb-8">
              Cette section est actuellement indisponible pour des raisons de maintenance due à un problème lié au serveur de base de données. 
              Promis, nous rétablirons la connexion le plus tôt possible, d'ici là vous pouvez contacter le propriétaire directement via cette adresse : 
              <a href="mailto:kouakouezechielk06@gmail.com" class="text-black dark:text-white border-b border-zinc-300 dark:border-zinc-700 hover:border-black dark:hover:border-white transition-colors">
                kouakouezechielk06@gmail.com
              </a>.
            </p>

            <button @click="$emit('close')"
              class="px-8 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full text-sm font-bold uppercase tracking-widest hover:opacity-80 transition-opacity">
              D'accord
            </button>
          </div>

        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from "vue";

defineProps(["isOpen"]);
const emit = defineEmits(["close"]);

const loading = ref(true);

onMounted(() => {
  setTimeout(() => {
    loading.value = false;
  }, 5000); 
});
</script>