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
              <i class="ph ph-check-circle"></i> Compétences mises en œuvres
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div v-for="skill in skills" :key="skill.code" class="flex items-start gap-3 p-3 bg-blue-50/50 rounded-xs border border-blue-100">
                <span class="font-bold text-blue-700 text-[10px] md:text-xs mt-0.5 bg-blue-100 px-1.5 py-0.5 rounded">{{ skill.code }}</span>
                <p class="text-xs md:text-sm text-gray-700 leading-snug">{{ skill.text }}</p>
              </div>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte</h3>
            <p class="text-xs md:text-sm text-gray-700 leading-relaxed italic bg-gray-50/50 p-4 rounded-xs border-l-2 border-gray-200">
              Dans le cadre du projet hackaton j'ai supervisé l'amélioration technique, le déploiement d'une infrastructure web complète, l'organisation et l'attribution des tâches. L'objectif était d'organiser les tâches afin d'assurer le rendu du projet dans les délais et aussi d'assurer l'interopérabilité des données via des API tout en garantissant un hébergement cloud robuste sur Microsoft Azure.
            </p>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-4">Démarche suivie</h3>
            <div class="space-y-8">
              
              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">1. Analyse et Développement (C11, C12)</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-4">Mise en place de Google Analytics pour le suivi du trafic et création des points de terminaison API.</p>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                  <div class="space-y-2">
                    <span class="text-[9px] font-bold text-gray-400 uppercase">Structure API développée</span>
                    <pre class="bg-zinc-900 text-zinc-100 p-3 rounded-xs text-[10px] overflow-x-auto shadow-inner custom-scrollbar"><code>GET /api/vi/data-interop
Authorization: Bearer [TOKEN_AZURE]

// Réponse JSON attendue
{
  "status": 200,
  "data": {
    "source": "azure-db",
    "records": 142
  }
}</code></pre>
                  </div>
                  <div class="space-y-2">
                    <span class="text-[9px] font-bold text-gray-400 uppercase">Snippet Google Analytics (GA4)</span>
                    <pre class="bg-zinc-900 text-zinc-100 p-3 rounded-xs text-[10px] overflow-x-auto shadow-inner custom-scrollbar"><code>&lt;script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"&gt;&lt;/script&gt;
&lt;script&gt;
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);} 
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX'); 
&lt;/script&gt;</code></pre>
                  </div>
                </div>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">2. Organisation et Gestion de Projet (C12)</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-4">Utilisation de Trello pour la répartition des tâches et le suivi du backlog, sprint et tâches terminées.</p>
                
                <div class="bg-transparent rounded-xs aspect-[21/9] flex flex-col items-center justify-center p-6 text-center">
                  <i class="ph ph-trello-logo text-4xl text-gray-400 mb-2"></i>
                  <img src="../../assets/trello_capture.png" alt="Capture d'écran de Trello">
                </div>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">3. Déploiement et Infrastructure (C17)</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-3">Configuration de l'hébergement Azure et attribution du nom de domaine officiel pour garantir une accessibilité robuste.</p>
              </div>

              <div class="border-l-2 border-[#060b24]/20 pl-4">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-2 uppercase tracking-wide">4. Migration et Tests (C5, C4)</h4>
                <p class="text-[11px] md:text-sm text-gray-600 mb-4">Migration des données du serveur distant vers le serveur local et exécution des tests validant l'intégrité de la plateforme.</p>
                
                <div class="bg-zinc-900 rounded-xs overflow-hidden shadow-inner">
                  <div class="bg-zinc-800 px-4 py-2 border-b border-zinc-700 flex justify-between items-center">
                    <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest">Console Bash - Migration MySQL </span>
                  </div>
                  <pre class="text-zinc-100 p-4 text-[10px] md:text-xs custom-scrollbar"><code># Export depuis le serveur distant 
mysqldump -h srv-distant.example.com -u admin -p --databases seyrin_db > backup_seyrin-db.sql

# Import sur le serveur local
mysql -u root -p hackaton_local < backup_seyrin-db.sql

# Vérification de l'intégrité (comptage utilisateurs) 
mysql -u root -p -e "SELECT COUNT(*) FROM seyrin-db_local.users;" </code></pre>
                </div>
              </div>
            </div>
          </section>

          <section class="bg-[#060b24] p-5 md:p-6 rounded-xs border border-[#060b24] text-white shadow-lg">
            <h3 class="text-base md:text-lg font-bold mb-3 flex items-center gap-2">
              <i class="ph ph-lightbulb"></i> Conclusion
            </h3>
            <p class="text-blue-50 text-[11px] md:text-sm leading-relaxed italic">
              Cette mission de Chef de Projet m'a permis de maîtriser l'ensemble de la chaîne de valeur d'un service numérique : de l'organisation au développement de la plateforme et à l'analyse de données, jusqu'au déploiement final sur une infrastructure cloud professionnelle.
            </p>
          </section>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const skills = [
  { code: 'C12', text: "Organisation du projet et attribution des tâches via Trello" },
  { code: 'C12', text: "Développement d'API et amélioration des fonctionnalités du site" },
  { code: 'C11', text: "Analyse de la présence en ligne avec Google Analytics" },
  { code: 'C17', text: "Déploiement sur Azure et gestion du nom de domaine" },
  { code: 'C4', text: "Tests d'intégralité du serveur et gestion des rôles GLPI" }
];

const imprimerPage = () => {
  window.print();
};

</script>

<style scoped>
pre { 
  font-family: 'Courier New', Courier, monospace; 
  line-height: 1.5;
  white-space: pre-wrap; 
  word-break: break-all;
}

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