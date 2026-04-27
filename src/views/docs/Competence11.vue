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
          <a href="/docs/Competence11.pdf" download class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs text-xs md:text-sm font-bold shadow-md hover:bg-opacity-90 transition-all">
            <i class="ph ph-download-simple"></i> Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-blue-600 font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Référencement et mesure d'audience avec Google Analytics</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Auteur : Ezechiel KOUAKOU | Session BTS 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8 text-[#000000e6]">
          
          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4 border-b pb-2">
              <i class="ph ph-list-checks"></i> Compétences mises en œuvre
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C11.1</span>
                <p class="text-xs md:text-sm font-medium italic">Référencer les services en ligne de l'organisation</p>
              </div>
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C11.2</span>
                <p class="text-xs md:text-sm font-medium italic">Mesurer la visibilité et analyser le comportement</p>
              </div>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte</h3>
            <p class="text-xs md:text-sm leading-relaxed bg-gray-50 p-4 rounded-xs border-l-4 border-[#060b24]">
              Dans le cadre du projet Hackathon, l'équipe Seyrin disposait d'un site vitrine hébergé sur GitHub Pages. L'objectif était de mettre en place un outil de mesure pour évaluer la visibilité du site en ligne et analyser le comportement des visiteurs grâce à Google Analytics.
            </p>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-4">Démarche suivie</h3>
            
            <div class="space-y-6">
              <div v-for="(step, index) in steps" :key="index" class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3 flex items-center gap-2">
                  <span class="bg-[#060b24] text-white w-5 h-5 md:w-6 md:h-6 flex items-center justify-center rounded-full text-[10px] md:text-xs">{{ index + 1 }}</span>
                  {{ step.title }}
                </h4>
                <p v-if="step.desc" class="text-[10px] md:text-xs text-gray-600 mb-3">{{ step.desc }}</p>
                
                <div v-if="step.code" class="relative group">
                  <pre class="bg-zinc-900 text-zinc-100 p-3 md:p-4 rounded-xs text-[9px] md:text-[11px] overflow-x-auto shadow-inner custom-scrollbar"><code>{{ step.code }}</code></pre>
                </div>

                <div v-if="step.table" class="mt-4 overflow-x-auto">
                  <table class="w-full text-left text-[10px] md:text-xs border-collapse">
                    <thead>
                      <tr class="bg-gray-100">
                        <th class="p-2 border border-gray-200 font-bold">Indicateur</th>
                        <th class="p-2 border border-gray-200 font-bold">Description</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="row in step.table" :key="row.label">
                        <td class="p-2 border border-gray-200 font-medium">{{ row.label }}</td>
                        <td class="p-2 border border-gray-200 text-gray-600">{{ row.val }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div v-if="step.quote" class="mt-2 p-3 bg-gray-50 rounded italic text-[10px] md:text-xs text-gray-600 border-l-2 border-gray-200">
                  "{{ step.quote }}"
                  <p class="mt-2 not-italic text-gray-700 text-xs md:text-sm">{{ step.subContent }}</p>
                </div>
              </div>
            </div>
          </section>

          <section class="bg-[#060b24] p-5 md:p-6 rounded-xs text-white shadow-lg">
            <h3 class="text-base md:text-lg font-bold mb-3 flex items-center gap-2">
              <i class="ph ph-lightbulb"></i> Conclusion
            </h3>
            <p class="text-blue-50 text-[11px] md:text-sm leading-relaxed italic">
              Cette réalisation professionnelle m'a permis de comprendre comment mesurer la visibilité d'un site web grâce à Google Analytics. J'ai appris à créer une propriété, à intégrer le script de suivi sur un site statique, et à analyser les indicateurs de fréquentation pour prendre des décisions basées sur des données concrètes.
            </p>
          </section>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const steps = [
  {
    title: "Création du compte et de la propriété Google Analytics",
    desc: "Configuration de la plateforme pour recevoir les données du site GitHub Pages.",
    code: `1. Connexion à analytics.google.com
2. Création d'une propriété pour le site vitrine
3. Configuration du flux de données web
4. Récupération de l'identifiant de mesure (G-XXXXXXXXXX)`
  },
  {
    title: "Intégration du script de suivi (gtag.js)",
    desc: "Insertion du code JavaScript dans la balise <head> du site pour activer la collecte.",
    // Utilisation de backticks et concaténation pour ne pas tromper le compilateur Vite
    code: `<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></scr` + `ipt>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</scr` + `ipt>`
  },
  {
    title: "Vérification du bon fonctionnement",
    desc: "Test en temps réel pour s'assurer que les flux de données remontent correctement.",
    quote: "Vérification en temps réel dans Google Analytics que les visites étaient bien détectées",
    subContent: "Contrôle de l'absence d'erreurs dans la console du navigateur et test multi-appareils."
  },
  {
    title: "Analyse des indicateurs de visibilité (KPI)",
    desc: "Exploitation du tableau de bord pour mesurer l'audience.",
    table: [
      { label: "Nombre de visiteurs", val: "Comptage des sessions sur une période donnée" },
      { label: "Pages consultées", val: "Accueil, Équipe, Documentation" },
      { label: "Sources de trafic", val: "Accès direct, moteur de recherche, réseaux sociaux" },
      { label: "Taux de rebond", val: "Pourcentage de visiteurs quittant après une seule page" }
    ]
  }
];

const imprimerPage = () => {
  window.print();
};
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");

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
  .rounded-xs { border-radius: 0 !important; border: none !important; }
  .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
}
</style>