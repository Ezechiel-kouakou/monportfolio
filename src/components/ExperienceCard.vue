<template>
  <div ref="cardRef" class="w-full">
    <Transition :name="exp.side === 'left' ? 'slide-left' : 'slide-right'">
      <div v-if="isCardVisible" class="experience-card group relative">
        <div class="loading-overlay bg-black dark:bg-white">
          <div class="dots-spinner border-white dark:border-black"></div>
        </div>

        <div class="content-box p-6 md:p-8 bg-black dark:bg-white rounded-xs shadow-2xl transition-colors duration-500 flex flex-col justify-between min-h-[220px]">
          <div>
            <h2 class="text-xl md:text-xl font-black text-white dark:text-black uppercase leading-tight">
              {{ exp.role }}
            </h2>

            <div class="flex items-center gap-4 md:gap-6 mt-6 mb-6">
              <div class="w-14 h-14 md:w-16 md:h-16 bg-white rounded-xl flex items-center justify-center p-2 border border-gray-200 shrink-0">
                <img :src="exp.logo" alt="logo" class="w-full h-full object-contain" />
              </div>
              <div>
                <p class="text-white dark:text-black font-extrabold text-base md:text-lg leading-tight">
                  {{ exp.company }}
                </p>
                <p class="text-blue-400 dark:text-blue-600 font-mono text-[10px] md:text-[12px] font-bold mt-1 lowercase tracking-widest">
                  {{ exp.period }}
                </p>
              </div>

              <div v-if="exp.iconOutils && exp.iconOutils.length > 0" class="ml-auto flex items-center gap-2">
                <div 
                  v-for="(icon, i) in exp.iconOutils" 
                  :key="i"
                  class="w-7 h-7 md:w-8 md:h-8 bg-white/10 dark:bg-black/5 border border-white/10 dark:border-black/10 rounded-md flex items-center justify-center p-1.5 shadow-sm hover:scale-110 transition-transform duration-300"
                >
                  <img :src="icon" alt="Outils" class="w-full h-full object-contain" />
                </div>
              </div>
            </div>
          </div>

          <div class="border-t border-white/10 dark:border-black/10 pt-4 mt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-gray-400 dark:text-gray-500 text-xs md:text-sm italic flex-1">
              {{ exp.desc }}
            </p>
            <button 
              @click="$emit('open-modal', exp)"
              class="px-4 py-2 text-[9px] font-sans font-bold uppercase tracking-wider border border-white/20 dark:border-black/20 text-blue-500 dark:text-blue-500 bg-transparent hover:bg-white hover:text-black dark:hover:bg-black dark:hover:text-white rounded-xs transition-all duration-300 self-end sm:self-center shrink-0 cursor-pointer box-shadow-lg"
            >
              En savoir plus →
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
const props = defineProps(["exp"]);
defineEmits(["open-modal"]); // Déclaration de l'événement pour le parent

const isCardVisible = ref(false);
const cardRef = ref(null);

onMounted(() => {
  const observer = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) {
        isCardVisible.value = true;
        observer.unobserve(entry.target);
      }
    },
    { threshold: 0.1 },
  );
  if (cardRef.value) observer.observe(cardRef.value);
});
</script>

<style scoped>
/* Conserve tes styles CSS existants à l'identique */
.slide-left-enter-active, .slide-right-enter-active {
  transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.slide-left-enter-from { opacity: 0; transform: translateX(-120px); }
.slide-right-enter-from { opacity: 0; transform: translateX(120px); }

@media (max-width: 768px) {
  .slide-left-enter-from { transform: translateX(-40px); }
  .slide-right-enter-from { transform: translateX(40px); }
}

.loading-overlay {
  position: absolute;
  inset: 0;
  border-radius: 1rem;
  z-index: 30;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: fadeOut 0.5s forwards 1.2s;
}

.dots-spinner {
  width: 30px;
  height: 30px;
  border-style: dotted;
  border-width: 3px;
  border-radius: 50%;
  animation: spin 1.5s linear infinite;
}

.content-box { opacity: 0; animation: fadeIn 0.5s forwards 1.4s; }

@keyframes spin { to { transform: rotate(360deg); } }
@keyframes fadeOut { to { opacity: 0; visibility: hidden; } }
@keyframes fadeIn { to { opacity: 1; } }
</style>