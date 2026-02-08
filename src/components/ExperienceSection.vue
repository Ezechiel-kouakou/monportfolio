<script setup>
import ExperienceCard from "./ExperienceCard.vue";
import logoEfrei from "../assets/efrei_logo.png";
import logoCarrefour from "../assets/logo_carrefour.png";
import logoETech from "../assets/E.TECH.png";

const experiences = [
  {
    role: "Projet académique - développement et réseau",
    company: "Efrei Paris",
    logo: logoEfrei,
    period: "Sept 2025 - Aujourd'hui",
    desc: "Projets académiques en développement et réseau.",
    side: "left",
  },
  {
    role: "Stage support informatique",
    company: "Carrefour",
    logo: logoCarrefour,
    period: "Mai 2024 - Août 2024",
    desc: "Support n1 et apport d'aide technique aux utilisateurs.",
    side: "right",
  },
  {
    role: "Développeur autodidacte",
    company: "E.TECH",
    logo: logoETech,
    period: "2024 - Aujourd'hui",
    desc: "Developpement de site vitrine, formulaire web et autres projets personnels.",
    side: "left",
  },
];
</script>
<template>
  <section
    id="experiences"
    class="bg-white dark:bg-black w-full py-20 md:py-32 text-black dark:text-white relative transition-colors duration-500"
  >
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl md:text-5xl font-black mb-16 md:mb-24 text-center uppercase italic tracking-tighter">
        Parcours Professionnel
      </h2>

      <div class="relative">
        <div
          class="absolute left-1/2 top-0 bottom-0 w-[1px] bg-black/20 dark:bg-white/20 -translate-x-1/2 hidden md:block"
        ></div>

        <div class="space-y-12 md:space-y-32">
          <div
            v-for="(exp, index) in experiences"
            :key="index"
            class="relative"
          >
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] items-start gap-8 md:gap-16">
              <div :class="[exp.side === 'left' ? 'block' : 'hidden md:block opacity-0', 'order-1 md:order-none']">
                <ExperienceCard :exp="exp" />
              </div>

              <div class="pt-14 hidden md:block z-10">
                <div
                  class="w-5 h-5 rounded-full bg-black dark:bg-white border-4 border-white dark:border-black shadow-lg"
                ></div>
              </div>

              <div :class="[exp.side === 'right' ? 'block' : 'hidden md:block opacity-0', 'order-1 md:order-none']">
                <ExperienceCard :exp="exp" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>