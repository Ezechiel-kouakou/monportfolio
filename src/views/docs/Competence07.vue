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
          <a href="/docs/Competence07.pdf" download class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs text-xs md:text-sm font-bold shadow-md hover:bg-opacity-90 transition-all">
            <i class="ph ph-download-simple"></i> Télécharger PDF
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="p-5 md:p-8 border-b border-gray-100 bg-gray-50/50">
          <h1 class="text-[10px] md:text-xs uppercase tracking-widest text-[#060b24] font-bold mb-2">Réalisation Professionnelle</h1>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">C7 - Collecte, suivi et orientation des demandes</h2>
          <p class="text-[11px] md:text-sm text-gray-500 mt-2">Auteur : Johan (INFRA) | Session BTS 2026</p>
        </div>

        <div class="p-5 md:p-8 space-y-6 md:space-y-8 text-[#000000e6]">
          
          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] flex items-center gap-2 mb-4 border-b pb-2">
              <i class="ph ph-list-checks"></i> Compétences mises en œuvre
            </h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs md:text-sm">
              <li class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex items-center gap-3">
                <i class="ph ph-check-circle text-blue-600"></i> Collecter, suivre et orienter des demandes
              </li>
              <li class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex items-center gap-3">
                <i class="ph ph-check-circle text-blue-600"></i> Traiter des demandes concernant les services réseau, système et applicatifs  
              </li>
              <li class="p-3 bg-blue-50/50 rounded-xs border border-blue-100 flex items-center gap-3 md:col-span-2">
                <i class="ph ph-check-circle text-blue-600"></i> Maîtrise d'un logiciel de gestion de parc et d'incidents (GLPI)
              </li>
            </ul>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-3">Contexte</h3>
            <p class="text-xs md:text-sm leading-relaxed bg-gray-50 p-4 rounded-xs border-l-4 border-[#060b24]">
              Dans le cadre d'un hackathon réalisé en groupe de 5 personnes à l'Efrei, notre équipe a été amenée à déployer et administrer une infrastructure informatique complète pour le site Seyrin, dans un temps limité. Nous avions été chargés d'utiliser GLPI pour gérer les tickets d'incidents et les demandes d'assistance émises par les membres de l'équipe tout au long du hackathon.
            </p>
          </section>

          <section>
            <h3 class="text-base md:text-lg font-bold text-[#060b24] mb-4">Démarche suivie</h3>
            <div class="space-y-6">
              <p class="text-xs md:text-sm text-gray-700">
                J'ai utilisé GLPI comme outil central de gestion des tickets d'incidents. Chaque demande ou problème signalé par un membre du groupe était formalisé sous forme de ticket, pris en charge, diagnostiqué puis résolu.
              </p>

              <div class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3">Tableau de bord GLPI</h4>
                <p class="text-[10px] md:text-xs text-gray-600 mb-4 italic">Hébergé sur Azure (seyrin-glpi.francecentral.cloudapp.azure.com), il permettait d'avoir une vue globale du parc et des tickets en cours.</p>
                <div class="bg-transparent rounded-xs aspect-video flex items-center justify-center text-gray-400 italic text-sm  border-gray-300">
                  <img src="../../assets/image_infra.png" alt="GLPI">
                </div>
              </div>

              <div class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3">Cycle de vie d'un ticket</h4>
                <div class="overflow-x-auto">
                  <table class="w-full text-left text-[10px] md:text-xs border-collapse">
                    <thead>
                      <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="p-2 font-bold text-[#060b24]">Étape</th>
                        <th class="p-2 font-bold text-[#060b24]">Statut</th>
                        <th class="p-2 font-bold text-[#060b24]">Description</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                      <tr><td class="p-2">1</td><td class="p-2 font-bold text-blue-600">Nouveau</td><td class="p-2">Le ticket est créé par un membre du groupe avec description du problème.</td></tr>
                      <tr><td class="p-2">2</td><td class="p-2 font-bold text-orange-500">En cours</td><td class="p-2">Le ticket est assigné au technicien compétent (Infra ou Support).</td></tr>
                      <tr><td class="p-2">4</td><td class="p-2 font-bold text-green-600">Résolu</td><td class="p-2">La solution est appliquée et documentée dans le ticket.</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3">Ticket #1 - Agent GLPI ne remonte pas l'inventaire</h4>
                <div class="space-y-2 text-[10px] md:text-xs text-gray-700">
                  <p><strong>Description :</strong> Après installation de l'agent GLPI sur le poste, la machine ne remonte pas dans l'inventaire.</p>
                  <p><strong>Diagnostic :</strong> L'URL dans agent.cfg pointait en HTTP au lieu de HTTPS. Le port 443 était fermé sur le pare-feu.</p>
                  <p class="text-green-700 font-semibold"><strong>Solution :</strong> Correction de l'URL en HTTPS, ouverture du port 443 via ufw et redémarrage du service glpi-agent.</p>
                </div>
                <pre class="mt-3 bg-zinc-900 text-zinc-100 p-3 rounded-xs text-[9px] md:text-[11px] overflow-x-auto"><code># Correction dans /etc/glpi-agent/agent.cfg :
server https://&lt;IP SERVEUR&gt;/glpi

# Ouverture du port 443 et restart:
sudo ufw allow 443/tcp
sudo systemctl restart glpi-agent</code></pre>
              </div>

              <div class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3">Ticket #2 - Accès refusé à l'interface GLPI</h4>
                <div class="space-y-2 text-[10px] md:text-xs text-gray-700">
                  <p><strong>Diagnostic :</strong> Le compte utilisateur avait été créé sans profil d'accès assigné.</p>
                  <p class="text-green-700 font-semibold"><strong>Solution :</strong> Attribution du profil "Technicien" au compte depuis l'administration GLPI.</p>
                </div>
              </div>

              <div class="bg-white p-4 md:p-5 border border-gray-100 rounded-xs shadow-sm">
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-3">Ticket #3 - Machine absente après redémarrage</h4>
                <p class="text-[10px] md:text-xs text-gray-700 mb-2"><strong>Solution :</strong> Activation du démarrage automatique avec <code>systemctl enable</code>.</p>
                <pre class="bg-zinc-900 text-zinc-100 p-3 rounded-xs text-[9px] md:text-[11px]"><code>sudo systemctl enable glpi-agent
sudo systemctl start glpi-agent</code></pre>
              </div>
            </div>
          </section>

          <section class="bg-[#060b24] p-5 md:p-6 rounded-xs text-white shadow-lg">
            <h3 class="text-base md:text-lg font-bold mb-3 flex items-center gap-2">
              <i class="ph ph-lightbulb"></i> Conclusion
            </h3>
            <p class="text-blue-50 text-[11px] md:text-sm leading-relaxed italic">
              Cette réalisation m'a permis de maîtriser GLPI pour automatiser l'inventaire d'un parc et gérer les incidents de manière structurée. J'ai appris à déployer l'agent sous Linux, à administrer les comptes avec droits différenciés et à développer une approche méthodique du diagnostic.
            </p>
          </section>

        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
const imprimerPage = () => {
  window.print();
};
</script>
<style scoped>
.min-h-screen {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}
pre { font-family: 'Courier New', Courier, monospace; line-height: 1.5; white-space: pre-wrap; word-break: break-all; }
.custom-scrollbar::-webkit-scrollbar { height: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #3f3f46; border-radius: 10px; }
@media print { .no-print { display: none !important; } .bg-[f3f2ef] { background: white !important; } }
</style>