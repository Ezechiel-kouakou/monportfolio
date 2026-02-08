<script setup>
import { ref } from "vue";
import Navbar from "../components/Navbar.vue";
import Hero from "../components/Hero.vue";
import Stats from "../components/Stats.vue";
import Experiences from "../components/ExperienceSection.vue";
import Projets from "../components/Projets.vue";
import ModalCV from "../components/ModalCV.vue";
import ModalContact from "../components/ModalContact.vue";

const isModalOpen = ref(false); 
const isContactModalOpen = ref(false);
</script>

<template>
  <main
    class="min-h-screen w-full bg-[#020617] text-white selection:bg-blue-500/30"
  >
    <Navbar @open-contact="isContactModalOpen = true" />

    <Hero>
      <template #actions>
        <button
          @click="isModalOpen = true"
          class="button px-8 py-4 light (zinc-100) bg-zinc-100/90 text-black rounded-br-lg font-bold lowercase tracking-widest transition-all duration-300 shadow-[inset_0_-4px_8px_rgba(0,0,0,0.1),_inset_0_4px_8px_rgba(255,255,255,0.8),_0_10px_25px_rgba(0,0,0,0.5)] border border-white/20 hover:bg-white hover:scale-105 active:scale-95"
        >
          Voir mon CV
        </button>
      </template>
    </Hero>

    <Stats />
    <Experiences />
    <Projets />

    <ModalCV :isOpen="isModalOpen" @close="isModalOpen = false" />

    <ModalContact
      :isOpen="isContactModalOpen"
      @close="isContactModalOpen = false"
    />
  </main>
</template>
