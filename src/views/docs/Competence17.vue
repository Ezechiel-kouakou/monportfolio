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
          <a href="/docs/Competence17.pdf" download class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs text-xs md:text-sm font-bold shadow-md hover:bg-opacity-90 transition-all">
            <i class="ph ph-download-simple"></i> Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-blue-600 font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Déploiement d'une infrastructure GLPI sécurisée sur Azure</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Auteur : Ezechiel Kouakou | Session BTS 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8 text-[#000000e6]">
          
          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4 border-b pb-2">
              <i class="ph ph-list-checks"></i> Compétences mises en œuvre
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C17.1</span>
                <p class="text-xs md:text-sm font-medium italic">Déployer et héberger un site web sur une infrastructure cloud</p>
              </div>
              <div class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex gap-3 items-center">
                <span class="bg-blue-600 text-white font-bold text-[9px] md:text-[10px] px-2 py-1 rounded">C17.2</span>
                <p class="text-xs md:text-sm font-medium italic">Sécuriser les communications web via HTTPS (SSL/TLS)</p>
              </div>
            </div>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte et objectifs</h3>
            <p class="text-xs md:text-sm leading-relaxed bg-gray-50 p-4 rounded-xs border-l-4 border-[#060b24]">
              L'objectif était de rendre une installation locale de GLPI accessible en ligne de manière sécurisée. La migration vers Microsoft Azure a permis de garantir un environnement fiable, complété par la configuration d'un nom de domaine professionnel et la sécurisation des échanges via le protocole HTTPS.
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
                        <th class="p-2 border border-gray-200 font-bold">Type</th>
                        <th class="p-2 border border-gray-200 font-bold">Nom</th>
                        <th class="p-2 border border-gray-200 font-bold">Valeur/TTL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="row in step.table" :key="row.label">
                        <td class="p-2 border border-gray-200 font-medium">{{ row.type }}</td>
                        <td class="p-2 border border-gray-200 text-gray-600">{{ row.nom }}</td>
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
              Cette réalisation m'a permis d'acquérir des compétences solides en infrastructure cloud (Azure) et en administration système sécurisée. J'ai appris à structurer des ressources distantes, à configurer une zone DNS et à automatiser la gestion des certificats SSL/TLS pour garantir l'intégrité des données.
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
    title: `Déploiement de l'infrastructure cloud (Azure)`,
    desc: `Création d'une VM Ubuntu Server et configuration du NSG pour autoriser les flux SSH (22), HTTP (80) et HTTPS (443).`,
    code: `az vm open-port --port 80 --resource-group MonGroupe --name MaVM
az vm open-port --port 443 --resource-group MonGroupe --name MaVM`
  },
  {
    title: `Installation et transfert de l'application`,
    desc: `Mise en place de la stack Apache/PHP et transfert des fichiers GLPI via SCP.`,
    code: `sudo apt update
sudo apt install -y apache2 php php-mysql php-curl php-gd php-xml php-mbstring
scp -r ./glpi/ azureuser@IP_PUBLIQUE_VM:/var/www/html/`
  },
  {
    title: `Configuration DNS du Nom de Domaine`,
    desc: `Configuration des entrées DNS de type A pour pointer vers l'adresse IP statique d'Azure.`,
    table: [
      { type: "A", nom: "@", val: "XXX.XXX.XXX.XXX (TTL 3600)" },
      { type: "A", nom: "www", val: "XXX.XXX.XXX.XXX (TTL 3600)" },
      { type: "A", nom: "glpi", val: "XXX.XXX.XXX.XXX (TTL 3600)" }
    ]
  },
  {
    title: `Sécurisation HTTPS (SSL/TLS via Let's Encrypt)`,
    desc: `Obtention et installation automatique du certificat via Certbot pour activer le HTTPS.`,
    code: `<VirtualHost *:443>
  ServerName glpi.monsite.fr
  SSLEngine on
  SSLCertificateFile /etc/letsencrypt/live/glpi.monsite.fr/fullchain.pem
  SSLCertificateKeyFile /etc/letsencrypt/live/glpi.monsite.fr/privkey.pem
</VirtualHost>`
  },
  {
    title: `Tests et Validation`,
    quote: `Vérification multi-niveaux`,
    subContent: `Validation DNS (nslookup), validation de la sécurité (cadenas affiché) et validation applicative depuis des réseaux externes (4G).`
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
  .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
}
</style>