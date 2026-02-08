<template>
  <div class="min-h-screen bg-[#020617] pt-32 px-6">
    <router-link to="/" class="text-blue-400 hover:underline mb-8 inline-block"
      >← Retour à l'accueil</router-link
    >
    <h1 class="text-4xl font-bold text-white mb-12">
      Bibliothèque complète des projets
    </h1>

    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div
        v-for="n in 12"
        :key="n"
        class="bg-white/5 p-6 rounded-2xl border border-white/10"
      >
        <h3 class="text-white font-bold">Projet Archive {{ n }}</h3>
      </div>
    </div>
  </div>
</template>
