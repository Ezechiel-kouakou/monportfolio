<template>
  <Teleport to="body">
    <Transition name="modal-fade">
      <div
  v-if="exp"
  class="fixed inset-0 z-[10000] flex items-center justify-center p-4 pb-28 md:p-8"
  @click.self="$emit('close')"
>
        <div class="absolute inset-0 bg-black/70 dark:bg-black/80 backdrop-blur-sm"></div>

        <Transition name="modal-scale" appear>
          <div
            v-if="exp"
            class="relative w-full max-w-2xl max-h-full flex flex-col bg-black dark:bg-white rounded-xs shadow-2xl border overflow-hidden"
            :style="{ borderColor: accent + '55' }"
          >
            <!-- === ZONE "DÉCOLLETÉE" : fond glow animé + watermark logo (taille fixe) === -->
            <div class="relative h-40 md:h-48 shrink-0 overflow-hidden bg-black dark:bg-white">
              <!-- <div class="absolute inset-0 hero-grid"></div> -->

              <div
                class="absolute -top-10 -left-10 w-56 h-56 rounded-full blur-3xl opacity-40 hero-blob-1"
                :style="{ background: accent }"
              ></div>
              <div
                class="absolute top-0 right-10 w-40 h-40 rounded-full blur-3xl opacity-30 hero-blob-2"
                :style="{ background: accent }"
              ></div>

              <div class="absolute -right-8 -bottom-10 w-56 h-56 md:w-64 md:h-64 opacity-[0.08] dark:opacity-[0.12] rotate-[-8deg] pointer-events-none">
                <img :src="exp.logo" alt="" class="w-full h-full object-contain grayscale" />
              </div>

              <div
                class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-b from-transparent to-black dark:to-white"
              ></div>

              <button
                @click="$emit('close')"
                class="absolute top-4 right-4 md:top-6 md:right-6 w-9 h-9 flex items-center justify-center rounded-full border border-white/30 dark:border-black/30 bg-black/30 dark:bg-white/30 backdrop-blur-sm text-white dark:text-black hover:bg-white hover:text-black dark:hover:bg-black dark:hover:text-white transition-all duration-300 cursor-pointer z-20"
                aria-label="Fermer"
              >
                ✕
              </button>
            </div>

            <!-- === CONTENU SCROLLABLE (prend tout l'espace restant) === -->
            <div class="relative z-10 -mt-10 md:-mt-12 flex-1 min-h-0 overflow-y-auto px-6 md:px-10 pb-8 md:pb-10">
              <div class="flex items-center gap-4 md:gap-6 mb-8">
                <div
                  class="w-16 h-16 md:w-20 md:h-20 bg-transparent rounded-xs flex items-center justify-center p-2  shadow-lg shrink-0"
                  :style="{ borderColor: accent + '55' }"
                >
                  <img :src="exp.logo" alt="logo" class="w-full h-full object-contain" />
                </div>
                <div class="pt-2">
                  <h3 class="text-xl md:text-2xl font-black text-white dark:text-black uppercase leading-tight">
                    {{ exp.role }}
                  </h3>
                  <p class="text-white dark:text-black font-extrabold text-sm md:text-base leading-tight mt-1">
                    {{ exp.company }}
                  </p>
                  <p
                    class="font-mono text-[10px] md:text-[12px] font-bold mt-1 lowercase tracking-widest"
                    :style="{ color: accent }"
                  >
                    {{ exp.period }}
                  </p>
                </div>
              </div>

              <p v-if="exp.desc" class="text-gray-400 dark:text-gray-500 text-sm md:text-base italic mb-6">
                {{ exp.desc }}
              </p>

              <div v-if="exp.details && exp.details.length" class="mb-8">
                <h4 class="text-white dark:text-black font-bold text-xs uppercase tracking-widest mb-3 border-b border-white/10 dark:border-black/10 pb-2">
                  Missions
                </h4>
                <ul class="space-y-2">
                  <li
                    v-for="(point, i) in exp.details"
                    :key="i"
                    class="text-gray-300 dark:text-gray-700 text-sm flex items-start gap-2"
                  >
                    <span :style="{ color: accent }" class="mt-1">▸</span>
                    <span>{{ point }}</span>
                  </li>
                </ul>
              </div>

              <div v-if="exp.iconOutils && exp.iconOutils.length" class="mb-2">
                <h4 class="text-white dark:text-black font-bold text-xs uppercase tracking-widest mb-3 border-b border-white/10 dark:border-black/10 pb-2">
                  Outils &amp; Technologies
                </h4>
                <div class="flex flex-wrap gap-3">
                  <div
                    v-for="(icon, i) in exp.iconOutils"
                    :key="i"
                    class="w-10 h-10 bg-white/10 dark:bg-black/5 border border-white/10 dark:border-black/10 rounded-md flex items-center justify-center p-2"
                  >
                    <img :src="icon" alt="Outil" class="w-full h-full object-contain" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { watch, onUnmounted, computed } from "vue";

const props = defineProps(["exp"]);
const emit = defineEmits(["close"]);

const accent = computed(() => props.exp?.accentColor || "#3b82f6");
const marqueeSpeed = computed(() => props.exp?.marqueeSpeed || "30s");

function handleKeydown(e) {
  if (e.key === "Escape") emit("close");
}

watch(
  () => props.exp,
  (val) => {
    if (val) {
      document.body.style.overflow = "hidden";
      window.addEventListener("keydown", handleKeydown);
    } else {
      document.body.style.overflow = "";
      window.removeEventListener("keydown", handleKeydown);
    }
  }
);

onUnmounted(() => {
  document.body.style.overflow = "";
  window.removeEventListener("keydown", handleKeydown);
});
</script>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.3s ease;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}

.modal-scale-enter-active {
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.modal-scale-leave-active {
  transition: all 0.2s ease;
}
.modal-scale-enter-from {
  opacity: 0;
  transform: scale(0.92) translateY(20px);
}
.modal-scale-leave-to {
  opacity: 0;
  transform: scale(0.96);
}

/* Grille fine en fond, subtile */
.hero-grid {
  background-image:
    linear-gradient(to right, currentColor 1px, transparent 1px),
    linear-gradient(to bottom, currentColor 1px, transparent 1px);
  background-size: 32px 32px;
  color: rgba(255, 255, 255, 0.035);
  mask-image: radial-gradient(ellipse 80% 80% at 50% 30%, black 40%, transparent 90%);
  -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 30%, black 40%, transparent 90%);
}
:global(.dark) .hero-grid {
  color: rgba(0, 0, 0, 0.04);
}

/* Blobs lumineux qui dérivent lentement */
.hero-blob-1 {
  animation: float-blob-1 9s ease-in-out infinite;
}
.hero-blob-2 {
  animation: float-blob-2 11s ease-in-out infinite;
}

@keyframes float-blob-1 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(20px, 15px) scale(1.15); }
}
@keyframes float-blob-2 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(-15px, 10px) scale(1.1); }
}

@media (prefers-reduced-motion: reduce) {
  .hero-blob-1, .hero-blob-2 { animation: none; }
}

</style>