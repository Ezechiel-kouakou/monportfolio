<template>
  <div class="min-h-screen bg-[#f3f2ef] p-4 md:p-8" style="font-family: Verdana, sans-serif;">
    <div class="max-w-5xl mx-auto">
      
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 no-print">
        <router-link to="/tableau-synthese" class="flex items-center gap-2 text-[#060b24] font-light hover:underline transition-all text-sm md:text-base">
          <i class="ph ph-arrow-left"></i> Retour au Tableau
        </router-link>
        
        <div class="flex w-full sm:w-auto gap-3">
          <button @click="imprimerPage" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-xs text-xs md:text-sm font-medium hover:bg-gray-50 shadow-sm">
            <i class="ph ph-printer"></i> Imprimer
          </button>
          
          <a href="/docs/Competence14.pdf" download class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs text-xs md:text-sm font-bold shadow-md hover:bg-opacity-90 transition-all">
            <i class="ph ph-download-simple"></i> Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-blue-600 font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Kouakou (Chef de Projet) : Pilotage et Déploiement</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Session BTS 2026 | Date : 24 avril 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8">
          
          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4">
              <i class="ph ph-check-circle"></i> Compétences managériales et techniques
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div v-for="skill in skills" :key="skill.code" class="flex items-start gap-3 p-3 bg-blue-50/50 rounded-xs border border-blue-100">
                <!-- <span class="font-bold text-blue-700 text-[10px] md:text-xs mt-0.5 bg-blue-100 px-1.5 py-0.5 rounded">{{ skill.code }}</span> -->
                <p class="text-xs md:text-sm text-gray-700 leading-snug">{{ skill.text }}</p>
              </div>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte de la mission</h3>
            <p class="text-xs md:text-sm text-gray-700 leading-relaxed italic bg-gray-50/50 p-4 rounded-xs border-l-2 border-gray-200">
              Dans le cadre du projet hackathon, j'ai assuré la direction technique et l'organisation structurelle de l'infrastructure web. Mon rôle a été de garantir le respect des jalons du projet via une gestion de tâches rigoureuse et de superviser l'interopérabilité des systèmes entre Microsoft Azure et les services tiers.
            </p>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-4">Méthodologie de Pilotage</h3>
            <div class="space-y-8">
              
              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">1. Organisation et Gestion de Projet</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-4">
                  Mise en place d'une méthodologie <strong>Kanban</strong> via l'outil <strong>Trello</strong> pour assurer une visibilité totale sur l'avancement du projet. J'ai structuré le flux de travail en colonnes distinctes pour optimiser la productivité de l'équipe :
                </p>
                
                <div class="grid grid-cols-3 gap-2 mb-6 text-center">
                    <div class="p-2 bg-gray-100 border border-gray-200 rounded text-[10px] font-bold uppercase text-gray-500">À Faire (Backlog)</div>
                    <div class="p-2 bg-blue-100 border border-blue-200 rounded text-[10px] font-bold uppercase text-blue-600">En Cours (Sprint)</div>
                    <div class="p-2 bg-green-100 border border-green-200 rounded text-[10px] font-bold uppercase text-green-600">Terminé (Done)</div>
                </div>

                <div class="bg-transparent rounded-xs aspect-[21/9] flex flex-col items-center justify-center p-6 text-center">
                  <i class="ph ph-trello-logo text-4xl text-gray-400 mb-2"></i>
                  <img src="../../assets/trello_capture.png" alt="Capture d'écran de Trello">
                </div>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">2. Supervision du Déploiement et Cloud</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-3">
                  Élaboration de la stratégie de mise en production sur <strong>Microsoft Azure</strong>. Ma mission a consisté à valider la configuration de l'hébergement et la gestion du nom de domaine officiel pour assurer une haute disponibilité du service.
                </p>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">3. Analyse de la Présence en Ligne</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-3">
                  Pilotage de l'intégration de <strong>Google Analytics (GA4)</strong>. L'objectif était de définir les indicateurs clés de performance (KPI) pour mesurer l'audience et l'impact du projet après son déploiement.
                </p>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">4. Validation de l'Intégrité</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-4">
                  Supervision des phases de tests d'interopérabilité. Validation finale de la migration des données pour garantir l'intégrité de la plateforme et la continuité de service lors du passage en environnement de production.
                </p>
              </div>
            </div>
          </section>

          <section class="bg-[#060b24] p-5 md:p-6 rounded-xs border border-[#060b24] text-white shadow-lg">
            <h3 class="text-base md:text-lg font-bold mb-3 flex items-center gap-2">
              <i class="ph ph-lightbulb"></i> Conclusion
            </h3>
            <p class="text-blue-50 text-[11px] md:text-sm leading-relaxed italic">
              Cette mission de Chef de Projet m'a permis de maîtriser l'intégralité de la chaîne de valeur d'un service numérique : de l'organisation agile à la prise de décision technique, jusqu'à l'analyse de performance sur une infrastructure Cloud professionnelle.
            </p>
          </section>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const skills = [
  {  text: "Pilotage de projet et coordination des équipes via Trello" },
  {  text: "Supervision du déploiement cloud sur Microsoft Azure" },
  {  text: "Analyse stratégique de l'audience avec Google Analytics" },
  {  text: "Contrôle qualité et validation de l'intégrité des systèmes" }
];

const imprimerPage = () => {
  window.print();
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  height: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #3f3f46;
  border-radius: 10px;
}

@media print {
  .no-print { display: none !important; }
  .bg-[f3f2ef] { background: white !important; }
  .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; border: none !important; }
}
</style>