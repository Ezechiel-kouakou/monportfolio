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
          <a href="/docs/Competence01.pdf" download class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs text-xs md:text-sm font-bold shadow-md hover:bg-opacity-90 transition-all">
            <i class="ph ph-download-simple"></i>Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-blue-600 font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Recensement d'un parc informatique avec GLPI</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Auteur : Ezechiel KOUAKOU | Session BTS 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8 text-[#000000e6]">
          
          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4 border-b pb-2">
              <i class="ph ph-list-checks"></i> Compétences mises en œuvre
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C1</span>
                <p class="text-xs md:text-sm font-medium italic">Recenser et identifier les ressources numériques</p>
              </div>
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C3</span>
                <p class="text-xs md:text-sm font-medium italic">Attribuer de rôle à chaque compte GLPI</p>
              </div>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte</h3>
            <p class="text-xs md:text-sm leading-relaxed bg-gray-50 p-4 rounded-xs border-l-4 border-[#060b24]">
              Dans le cadre d'un hackathon, nous avons mis en place un outil de gestion de parc informatique afin de centraliser les informations des équipements et des utilisateurs. L'objectif était d'avoir une vision claire du parc informatique grâce à GLPI.
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
              Cette réalisation m'a permis d'apprendre à structurer un parc informatique en centralisant les informations. J'ai acquis des compétences dans le déploiement d'agents sur plusieurs machines et dans l'exploitation des données pour la gestion du système d'information.
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
    title: "Installation de GLPI sur le serveur Linux",
    desc: "Mise en place des dépendances (Apache, PHP, MariaDB) et démarrage des services.",
    code: `sudo apt update\nsudo apt install apache2 php php-mysql php-curl php-gd php-xml php-mbstring mariadb-server\nsudo systemctl start apache2`
  },
  {
    title: "Configuration de la base de données",
    code: `CREATE DATABASE glpi;\nCREATE USER 'glpi'@'localhost' IDENTIFIED BY 'motdepasse';\nGRANT ALL PRIVILEGES ON glpi.* TO 'glpi'@'localhost';`
  },
  {
    title: "Installation et configuration de l'agent",
    desc: "Installation de glpi-agent pour la remontée automatique des informations.",
    code: `sudo apt install glpi-agent\nsudo nano /etc/glpi-agent/agent.cfg\n# server = http://IP_SERVEUR/glpi`
  },
  {
    title: "Gestion des accès et attribution des rôles",
    quote: "Attribuer de rôle à chaque compte glpi",
    subContent: "J'ai attribué les rôles à chaque compte (administrateur, technicien, utilisateur) afin de gérer les droits d'accès."
  }
];

const imprimerPage = () => {
  window.print();
};

</script>

<style scoped>
pre { 
  font-family: 'Courier New', Courier, monospace; 
  line-height: 1.5;
  white-space: pre-wrap; /* Permet le retour à la ligne sur mobile si le code est trop long */
  word-break: break-all;
}

.custom-scrollbar::-webkit-scrollbar {
  height: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #3f3f46;
  border-radius: 10px;
}

@media (max-width: 640px) {
  /* Réduction spécifique pour les très petits écrans */
  pre {
    font-size: 8px !important;
    padding: 10px !important;
  }
}

@media print {
  .no-print { display: none !important; }
  .bg-[f3f2ef] { background: white !important; }
  .rounded-xl { border-radius: 0 !important; border: none !important; }
  .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
}
</style>