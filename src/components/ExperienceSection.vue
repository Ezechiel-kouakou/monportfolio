<script setup>
import ExperienceCard from "./ExperienceCard.vue";
import logoEfrei from "../assets/efrei_logo.png";
import logoCarrefour from "../assets/logo_carrefour.png";
import logoETech from "../assets/E.TECH.png";
import logoGroupSSM from "../assets/logo_group_ssm.jpg";
import ExperienceModal from "./ExperienceModal.vue";
import { ref } from "vue";

const selectedExp = ref(null);

function openModal(exp) {
  selectedExp.value = exp;
}
function closeModal() {
  selectedExp.value = null;
}
const experiences = [
 {
    role: "Stage technicien support informatique",
    company: "Group SSM",
    logo: logoGroupSSM,
    period: "Mai 2026 - Actuel",
    accentColor: "#004E9F",
    iconOutils: [
      "https://img.icons8.com/fluency/48/microsoft-365.png",
      "https://img.icons8.com/color/48/windows-10.png",
      "https://cdn.simpleicons.org/datto/00A4E4",
      "https://img.icons8.com/fluency/48/anydesk.png",
    ],
    desc: "Support technique de niveau 1 et 2, administration de parc informatique",
    details: [
   "Diagnostic et résolution d'incidents matériels, logiciels et réseau (Niveau 1 et 2).",
    "Supervision et gestion de parc en temps réel via la solution de RMM (Datto RMM).",
    "Déploiement, configuration et sécurisation des postes de travail des collaborateurs.",
    "Création et mise à jour de la documentation technique et des procédures de support.",
    ],
    side: "right",
  },  
{
  role: "Stage support informatique",
  company: "Carrefour",
  logo: logoCarrefour,
  period: "Juin 2025 - Août 2025",
  accentColor: "#004E9F",
  iconOutils: [
    "https://img.icons8.com/fluency/48/microsoft-365.png",
    "https://img.icons8.com/color/48/windows-10.png",
  ],
  desc: "Support n1 et apport d'aide technique aux utilisateurs.",
  details: [
    "Diagnostic et résolution d'incidents matériels et logiciels niveau 1.",
    "Gestion des tickets et suivi via l'outil de support interne.",
    "Configuration de postes de travail et accompagnement des utilisateurs.",
  ],
  side: "left",
},
{
    role: "Projet académique - Réseau & Administration Système",
    company: "Efrei Paris",
    logo: logoEfrei,
    period: "Sept 2025 - Aujourd'hui",
    accentColor: "#004E9F",
    iconOutils: [
      "https://img.icons8.com/color/48/nmap.png",
      "https://img.icons8.com/color/48/linux.png",  
      "https://img.icons8.com/color/48/windows-10.png",
      "https://img.icons8.com/ios/50/cisco-packet-tracer.png"
],
    desc: "Mise en place d'un réseau local et administration de serveurs Wind.",
    details: [
      "Mise en place d'un réseau local avec configuration de routeurs et switchs.",
      "Administration de serveurs Linux et Windows pour la gestion des services réseau.",
      "Analyse du trafic réseau et résolution de problèmes de connectivité.",

    ],
    side: "right",
  },
  {
    role: "Home Lab - Développement Web & Réseau",
    company: "E.TECH",
    logo: logoETech,
    period: "2024 - Aujourd'hui",
    iconOutils:[
      "https://img.icons8.com/external-tal-revivo-shadow-tal-revivo/24/external-ubuntu-is-a-free-and-open-source-linux-distribution-logo-shadow-tal-revivo.png",
      "https://img.icons8.com/color/48/nodejs.png",
      "https://img.icons8.com/external-tal-revivo-shadow-tal-revivo/24/external-hypertext-preprocessor-a-widely-used-open-source-general-purpose-scripting-language-logo-shadow-tal-revivo.png",
      "https://img.icons8.com/fluency/48/azure-1.png"
    ],
    desc: "Developpement de site vitrine, formulaire web et autres projets personnels.",
    details: [
      "Création d'un site vitrine pour présenter mes projets et compétences.",
      "Développement d'un formulaire web pour la collecte de données.",
      "Mise en place d'un serveur web local pour tester et déployer les projets.",
    ],
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
          <!-- debut ajout -->
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] items-start gap-8 md:gap-16">
<div :class="[exp.side === 'left' ? 'block' : 'hidden md:block opacity-0', 'order-1 md:order-none']">
  <ExperienceCard :exp="exp" @open-modal="openModal" />
</div>

              <div class="pt-14 hidden md:block z-10">
  <div
    class="w-5 h-5 rounded-full bg-black dark:bg-white border-4 border-white dark:border-black shadow-lg"
  ></div>
</div>

             <div :class="[exp.side === 'right' ? 'block' : 'hidden md:block opacity-0', 'order-1 md:order-none']">
  <ExperienceCard :exp="exp" @open-modal="openModal" />
</div>

<!-- fin ajout -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <ExperienceModal :exp="selectedExp" @close="closeModal" />
  </section>
</template>