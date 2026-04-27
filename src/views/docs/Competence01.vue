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
            <i class="ph ph-download-simple"></i> Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-blue-600 font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Recensement d'un parc informatique avec GLPI</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Auteur : Firdaous AMADOU | Session BTS 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8 text-[#000000e6]">
          
          <section class="space-y-3">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
              <i class="ph ph-image"></i> Preuve de mise en service : data set utilisateur GLPI
            </h3>
            <div class="rounded-xs overflow-hidden bg-gray-100 shadow-inner">
              <img src="../../assets/compet_image_3.png" alt="Interface de connexion GLPI Ecotech" class="w-full h-auto" />
              <p class="p-2 text-[10px] text-gray-500 italic bg-white border-t">Capture 1 : recensement des utilisateurs.</p>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4 border-b pb-2">
              <i class="ph ph-list-checks"></i> Compétence mise en œuvre
            </h3>
            <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center w-fit">
              <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C1</span>
              <p class="text-xs md:text-sm font-medium italic">Recenser et identifier les ressources numériques</p>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte</h3>
            <p class="text-xs md:text-sm leading-relaxed bg-gray-50 p-4 rounded-xs border-l-4 border-[#060b24]">
              Dans le cadre d'un hackathon, l'objectif était de centraliser la gestion des actifs (matériels et logiciels) et des utilisateurs. L'utilisation de GLPI couplé à un agent d'inventaire a permis d'automatiser la remontée d'informations pour une vision précise du SI.
            </p>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-4">Démarche et Installation</h3>
            <div class="space-y-6">
              <div v-for="(step, index) in steps" :key="index" class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3 flex items-center gap-2">
                  <span class="bg-[#060b24] text-white w-5 h-5 md:w-6 md:h-6 flex items-center justify-center rounded-full text-[10px] md:text-xs">{{ index + 1 }}</span>
                  {{ step.title }}
                </h4>
                
                <div v-if="step.code" class="relative group">
                  <pre class="bg-zinc-900 text-zinc-100 p-3 md:p-4 rounded-xs text-[9px] md:text-[11px] overflow-x-auto shadow-inner custom-scrollbar"><code>{{ step.code }}</code></pre>
                </div>

                <p v-if="step.desc" class="text-[10px] md:text-xs text-gray-600 mt-3 leading-relaxed">{{ step.desc }}</p>

                <div v-if="step.hasImage" class="mt-4 rounded-xs overflow-hidden">
                   <div class="bg-gray-200 p-1 text-[9px] text-center font-light text-gray-600">VISUEL DE L'ÉTAPE</div>
                   <div class="h-120 bg-gray-50 flex items-center justify-center text-gray-400 text-[10px] italic">
                     <img src="../../assets/compet_image_1.png" alt="Capture d'écran de l'étape" class="w-full h-full object-cover" />
                   </div>
                </div>
              </div>
            </div>
          </section>

          <section class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border border-gray-200 rounded-xs">
              <h4 class="text-xs font-bold text-[#060b24] uppercase mb-3 flex items-center gap-2">
                <i class="ph ph-users"></i> Utilisateurs Identifiés
              </h4>
              <div class="flex flex-wrap gap-2">
                <span v-for="user in ['Amadou: Support', 'Ezechiel: Chef projet', 'Johan: Infra/Ops', 'Kylian: Support', 'Rayan: Infra/Ops',]" :key="user" class="px-2 py-1 bg-gray-100 text-[10px] rounded-full border border-gray-200">
                  {{ user }}
                </span>
              </div>
            </div>
            <div class="p-4 border border-gray-200 rounded-xs">
              <h4 class="text-xs font-bold text-[#060b24] uppercase mb-3 flex items-center gap-2">
                <i class="ph ph-hard-drives"></i> Inventaire Machine
              </h4>
              <p class="text-[10px] text-gray-600 italic">
                Remontée automatique via glpi-agent :<br>
                - Système : Ubuntu 24.04.3 LTS<br>
                - Architecture : x86_64 / VMware
              </p>
            </div>
          </section>

          <section class="bg-[#060b24] p-5 md:p-6 rounded-xs text-white shadow-lg">
            <h3 class="text-base md:text-lg font-bold mb-3 flex items-center gap-2">
              <i class="ph ph-lightbulb"></i> Conclusion
            </h3>
            <p class="text-blue-50 text-[11px] md:text-sm leading-relaxed italic">
              Grâce à cette réalisation, j'ai appris à automatiser le recensement des ressources numériques. L'utilisation d'un agent d'inventaire permet non seulement de gagner du temps mais aussi d'assurer une mise à jour en temps réel des logiciels et matériels du parc, garantissant une meilleure gestion du SI.
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
    title: `Installation de la stack LAMP`,
    code: `sudo apt update
sudo apt install apache2 php php-mysql mariadb-server
sudo systemctl start apache2`,
    desc: `Mise en place de l'environnement serveur pour accueillir GLPI.`
  },
  {
    title: `Configuration de la Base de Données`,
    code: `CREATE DATABASE glpi;
CREATE USER 'glpi'@'localhost' IDENTIFIED BY 'motdepasse';
GRANT ALL PRIVILEGES ON glpi.* TO 'glpi'@'localhost';`,
    desc: `Sécurisation et préparation de l'espace de stockage des données d'inventaire.`
  },
  {
    title: `Inventaire automatique via Agent`,
    code: `sudo apt install glpi-agent
# Configuration du serveur cible
server=http://192.168.x.x/glpi`,
    desc: `Installation de l'agent sur les postes clients pour une remontée automatique des caractéristiques matérielles et logicielles.`,
    hasImage: true
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
}
</style>