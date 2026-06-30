<script setup>
import { ref, onMounted } from "vue";

const isVisible = ref(false);
const sectionRef = ref(null);

const stacks = [
  {
    name: "Linux",
    icon:  "https://img.icons8.com/external-those-icons-flat-those-icons/24/external-Linux-logos-and-brands-those-icons-flat-those-icons.png",
    dir: "from-left",
    delay: "delay-100",
  },
  {
    name: "PHP",
    icon: "https://cdn.simpleicons.org/php/777BB4",
    dir: "from-top",
    delay: "delay-300",
  },
  {
    name: "HTML/CSS",
    icon: "https://cdn.simpleicons.org/html5/E34F26",
    dir: "from-bottom",
    delay: "delay-500",
  },
  {
    name: "Node.js",
    icon: "https://cdn.simpleicons.org/nodedotjs/339933",
    dir: "from-top",
    delay: "delay-700",
  },
  {
    name: "Windows",
    icon: "https://img.icons8.com/color/48/windows-10.png",
    dir: "from-right",
    delay: "delay-900",
  },
];

onMounted(() => {
  const observer = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) {
        isVisible.value = true;
      }
    },
    { threshold: 0.3 },
  );

  if (sectionRef.value) observer.observe(sectionRef.value);
});
</script>

<template>
  <section class="bg-white dark:bg-black w-full py-12 md:py-20 overflow-hidden transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6" ref="sectionRef">
      <div
        class="grid grid-cols-2 md:grid-cols-5 gap-6 md:gap-5 p-8 md:p-12 bg-zinc-50 dark:bg-[#080808] border border-zinc-200 dark:border-white/5 rounded-[2rem] md:rounded-[3rem] shadow-xl dark:shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden transition-all duration-500"
      >
        <div
          v-for="stack in stacks"
          :key="stack.name"
          class="relative flex flex-col items-center justify-center"
        >
          <div
            class="transition-all duration-[1500ms] ease-[cubic-bezier(0.23,1,0.32,1)]"
            :class="[
              stack.delay,
              isVisible
                ? 'translate-x-0 translate-y-0 opacity-100'
                : 'opacity-0',
              !isVisible && stack.dir === 'from-left'
                ? 'md:-translate-x-40 -translate-y-10'
                : '',
              !isVisible && stack.dir === 'from-right'
                ? 'md:translate-x-40 -translate-y-10'
                : '',
              !isVisible && stack.dir === 'from-top'
                ? '-translate-y-20 md:-translate-y-40'
                : '',
              !isVisible && stack.dir === 'from-bottom'
                ? 'translate-y-20 md:translate-y-40'
                : '',
            ]"
          >
            <div
              class="w-16 h-16 md:w-20 md:h-20 bg-white dark:bg-black rounded-2xl md:rounded-3xl flex items-center justify-center mb-4 md:mb-5 border border-zinc-200 dark:border-white/10 group hover:border-black dark:hover:border-blue-500 transition-all duration-500 shadow-sm dark:shadow-none"
            >
              <img
                :src="stack.icon"
                :alt="stack.name"
                class="w-8 h-8 md:w-10 md:h-10 group-hover:scale-110 transition-transform duration-300"
              />
            </div>

            <div class="text-center">
              <span class="stack-name text-[10px] md:text-[12px] text-zinc-900 dark:text-white transition-colors duration-500">
                {{ stack.name }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.stack-name {
  display: block;
  font-weight: 200;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  font-family: "Segoe UI", sans-serif;
}

@media (min-width: 768px) {
  .stack-name {
    letter-spacing: 0.3em;
  }
}

.delay-100 { transition-delay: 150ms; }
.delay-300 { transition-delay: 350ms; }
.delay-500 { transition-delay: 550ms; }
.delay-700 { transition-delay: 750ms; }
.delay-900 { transition-delay: 950ms; }
</style>