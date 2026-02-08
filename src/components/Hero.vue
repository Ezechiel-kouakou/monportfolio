<script setup>
import { onMounted, ref } from "vue";
import maPhoto from "../assets/photo_ezechiel.jpeg";
import { Linkedin, Github } from "lucide-vue-next";

const isVisible = ref(false);

onMounted(() => {
  setTimeout(() => {
    isVisible.value = true;
  }, 800);
});
</script>

<template>
  <section
    class="bg-white dark:bg-noir-piano min-h-screen w-full relative flex items-center justify-center overflow-hidden px-6 py-20 md:py-0 transition-colors duration-500"
  >
    <div
      class="z-10 max-w-7xl w-full flex flex-col md:flex-row items-center gap-10 md:gap-16"
    >
      <div
        class="flex-1 flex justify-center md:justify-start transition-all duration-1000 ease-[cubic-bezier(0.23,1,0.32,1)]"
        :class="
          isVisible
            ? 'translate-x-0 opacity-100'
            : 'md:-translate-x-24 -translate-y-12 opacity-0'
        "
      >
        <div class="relative group">
          <div
            class="relative z-10 w-56 h-56 md:w-96 md:h-96 border-0 border-white overflow-hidden rounded-2xl shadow-2xl"
          >
            <img
              :src="maPhoto"
              alt="Ezechiel"
              class="w-full h-full object-cover object-top grayscale transition-all duration-500 group-hover:grayscale-0 group-hover:scale-105"
            />
          </div>

          <div
            class="absolute -top-3 -left-3 md:-top-4 md:-left-4 bg-zinc-900 dark:bg-white text-white dark:text-black px-3 py-1 md:px-4 md:py-2 font-bold uppercase text-[10px] md:text-xs tracking-widest skew-x-[-12deg] z-20 shadow-lg transition-colors"
          >
            Étudiant
          </div>
        </div>
      </div>

      <div
        class="flex-1 text-center md:text-left transition-all duration-1000 ease-[cubic-bezier(0.23,1,0.32,1)] delay-150"
        :class="
          isVisible
            ? 'translate-x-0 opacity-100'
            : 'md:translate-x-24 translate-y-12 opacity-0'
        "
      >
        <h1
          class="text-zinc-900 dark:text-white text-5xl md:text-8xl font-black tracking-tighter mb-4 leading-none font-display transition-colors"
        >
          Ezechiel
        </h1>

        <div
          class="h-1 w-16 md:w-20 bg-zinc-900 dark:bg-white mb-6 md:mb-8 mx-auto md:mx-0 transition-colors"
        ></div>

        <p
          class="text-zinc-600 dark:text-white/80 text-base md:text-2xl capitalize tracking-[0.1em] md:tracking-[0.2em] font-light leading-relaxed transition-colors"
        >
          Étudiant en 1ère année de BTS SIO,<br />
          <span class="font-bold text-zinc-900 dark:text-white">Développement Web & Réseau.</span>
        </p>

        <div class="mt-6 md:mt-8 flex justify-center md:justify-start gap-6">
          <a
            href="https://linkedin.com"
            target="_blank"
            class="text-zinc-400 dark:text-white/30 hover:text-blue-500 transition-all duration-300"
          >
            <Linkedin
              :size="26"
              class="md:w-[30px] md:h-[30px]"
              stroke-width="1.5"
            />
          </a>
          <a
            href="https://github.com"
            target="_blank"
            class="text-zinc-400 dark:text-white/30 hover:text-zinc-900 dark:hover:text-white transition-all duration-300"
          >
            <Github
              :size="26"
              class="md:w-[30px] md:h-[30px]"
              stroke-width="1.5"
            />
          </a>
        </div>

        <div
          class="mt-8 md:mt-10 flex flex-wrap justify-center md:justify-start gap-4"
        >
          <slot name="actions"></slot>
        </div>
      </div>
    </div>
  </section>
</template>