<template>
  <div class="min-h-screen bg-transparent  flex items-center justify-center">
    <div class="max-w-md w-full text-center">
      
      <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-xs  mb-8">
        <i class="ph ph-smiley-sad text-8xl text-gray-400"></i>
      </div>

      <h2 class="text-2xl md:text-3xl font-bold text-[#060b24] mb-4">
        Oups !
      </h2>
      <!-- class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6] font-family: Verdana, Geneva, Tahoma, sans-serif; p-4 md:p-8" -->
      <p class="text-sm md:text-base text-gray-500 leading-relaxed mb-8">
        Désolé, cette page n'a pas encore de documentation achevé. 
        <span class="block mt-2 font-medium text-gray-600">
          Je m'efforce de les mettre à votre disposition dans les plus brefs délais.
        </span>
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <!-- <router-link 
          to="/tableau-synthese" 
          class="flex items-center justify-center gap-2 px-6 py-3 bg-[#060b24] text-white rounded-xl font-bold text-sm shadow-lg hover:scale-105 transition-all"
        >
          <i class="ph ph-arrow-left"></i>
          Retour au tableau
        </router-link> -->
        
        <button 
          @click="$router.go(-1)"
          class="flex items-center justify-center gap-2 px-6 py-3 bg-[#060b24] border border-gray-200 text-white rounded-xl font-light text-sm hover:bg-transparent-50 transition-all shadow-lg"
        >
          Page précédente
        </button>
      </div>

      <div class="mt-12 inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
        <!-- <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
        </span> -->
        <!-- Mise à jour en cours -->
      </div>

    </div>
  </div>
</template>

<style scoped>
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
/* .animate-bounce-slow {
  animation: bounce-slow 3s ease-in-out infinite;
} */
.min-h-screen {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}
</style>