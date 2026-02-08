<template>
  <div ref="cardRef" class="w-full">
    <Transition :name="exp.side === 'left' ? 'slide-left' : 'slide-right'">
      <div v-if="isCardVisible" class="experience-card group relative">
        <div class="loading-overlay bg-black dark:bg-white">
          <div class="dots-spinner border-white dark:border-black"></div>
        </div>

        <div class="content-box p-6 md:p-8 bg-black dark:bg-white rounded-2xl shadow-2xl transition-colors duration-500">
          <h3
            class="text-xl md:text-2xl font-black text-white dark:text-black uppercase leading-tight"
          >
            {{ exp.role }}
          </h3>

          <div class="flex items-center gap-4 md:gap-6 mt-6 mb-6">
            <div
              class="w-14 h-14 md:w-16 md:h-16 bg-white rounded-xl flex items-center justify-center p-2 border border-gray-200 shrink-0"
            >
              <img :src="exp.logo" alt="logo" class="w-full h-full object-contain" />
            </div>
            <div>
              <p class="text-white dark:text-black font-extrabold text-base md:text-lg leading-tight">
                {{ exp.company }}
              </p>
              <p class="text-blue-400 dark:text-blue-600 font-mono text-[10px] md:text-[11px] font-bold mt-1 uppercase">
                {{ exp.period }}
              </p>
            </div>
          </div>
          <p class="text-gray-400 dark:text-gray-500 text-xs md:text-sm italic border-t border-white/10 dark:border-black/10 pt-4">
            {{ exp.desc }}
          </p>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
const props = defineProps(["exp"]);
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
    { threshold: 0.3 },
  );
  if (cardRef.value) observer.observe(cardRef.value);
});
</script>

<style scoped>
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