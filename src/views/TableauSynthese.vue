<template>
  <div class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6] font-family: Verdana, Geneva, Tahoma, sans-serif; p-4 md:p-8">
    
 <div class="max-w-[1400px] mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div class="flex items-center gap-3">
    <div class="bg-transparent p-2 rounded hidden xs:block">
      <i class="ph ph-layout text-[#060b24] text-xl md:text-2xl"></i>
    </div>
    <div>
      <h1 class="text-lg md:text-xl font-bold tracking-tight leading-tight">Tableau de Synthèse Professionnelle</h1>
      <p class="text-[10px] md:text-[11px] text-gray-500 font-medium">Session BTS 2026 - Mis à jour le {{ miseAjourTotale }}</p>
    </div>
  </div>
     <button @click="imprimerPage" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-xs text-xs md:text-sm font-medium hover:bg-gray-50 shadow-sm">
  <i class="ph ph-printer"></i> Imprimer en PDF
</button>
</div>

    <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">
      
      <div class="lg:col-span-9 space-y-6">
        
        <div class="bg-white rounded-xs border border-gray-200 overflow-hidden shadow-sm">
          <div class="h-20 bg-[#060b24] "></div>
          <div class="px-8 pb-6">
            <div class="flex justify-between items-start -mt-10">
              <div class="bg-transparent p-1 rounded-x  border-gray-200 ">
                <div class="bg-transparent h-30 w-30 rounded-lg flex items-center justify-center border-gray-100">
                  <!-- <i class="ph-bold ph-user text-4xl text-gray-300"></i> -->
                   <img src="../assets/ezechiel_photo.png" alt="Photo de profil" class="h-full w-full object-cover rounded-x">
                </div>
              </div>
             <div class="mt-12 flex justify-end">
  <a :href="'https://' + profile.url" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-white/50 text-black font-medium rounded-lg text-[11px] md:text-sm border border-transparent hover:bg-white transition-colors max-w-[180px] md:max-w-none">
    <i class="ph ph-google-chrome-logo text-[#060b24] text-xl md:text-2xl"></i> 
    <span class="truncate">{{ profile.url }}</span>
  </a>
</div>
            </div>
            
  <div class="mt-4">
  <h2 class="text-xl md:text-2xl font-bold text-gray-900 capitalize">{{ profile.nom }}</h2>
  
  <div class="flex flex-wrap items-center gap-x-3 gap-y-3 mt-2 text-xs md:text-sm text-gray-600">
    <span class="font-semibold text-gray-800 whitespace-nowrap">Candidat n°{{ profile.candidat }}</span>
    
    <span class="hidden sm:inline text-gray-300">|</span>
    
    <span class="whitespace-nowrap">Option <b class="text-[#060b24]">{{ profile.option }}</b></span>
    
    <span class="hidden sm:inline text-gray-300">|</span>
    
    <span class="flex items-center gap-1 whitespace-nowrap">
      <i class="ph ph-buildings text-[#060b24] text-lg"></i> 
      Efrei Paris
    </span>

    <span class="hidden lg:inline text-gray-300">|</span>
    <button @click="showExcelPreview = true" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#1d6f42] text-white rounded-xs text-[10px] md:text-[11px] font-bold hover:bg-opacity-90 transition-all shadow-sm">
      <i class="ph ph-file-xls text-base"></i> Version Excel
    </button>
    <p class="w-full text-gray-500 text-[10px] mt-1 lowercase tracking-tighter italic"><i class="ph ph-info text-[#2e4ff2] text-base"></i> Vous avez accès à la version Excel du tableau de synthèse</p>
  </div>
</div>
          </div>
        </div>

        <div class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
          <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
              <i class="ph ph-list-checks text-[#060b24]"></i> Tableau de Synthèse des Réalisations et Compétences
            </h3>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-[13px] border-collapse">
              <thead>
                <tr class="bg-white text-gray-500 text-[10px] capitalize tracking-wider">
                  <th class="px-6 py-4 text-left font-black border-b border-r border-gray-100 w-1/4 ">Réalisation</th>
                  <th class="px-4 py-4 text-center font-black border-b border-r border-gray-100 w-24">Période</th>
                  <th v-for="skill in skillLabelsFull" :key="skill" class="px-2 py-4 text-center border-b border-r border-gray-100 bg-blue-50/30 text-[#060b24] lowercase first-letter:uppercase font-family: Verdana, Geneva, Tahoma, sans-serif; leading-tight min-w-[100px]">
                    {{ skill }}
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100">
  <tr v-if="realisations.length === 0">
    <td :colspan="2 + skillLabelsFull.length" class="px-6 py-20 text-center">
      <div class="flex flex-col items-center gap-3 opacity-40">
        <i class="ph ph-folder-open text-5xl"></i>
        <p class="text-xs font-light lowercase tracking-widest italic">
          aucune compétence n'a été rajoutée pour le moment.
        </p>
      </div>
    </td>
  </tr>

  <tr v-else v-for="real in realisations" :key="real.id" class="hover:bg-blue-50/20 transition-colors">
    <td class="px-6 py-6 border-r border-gray-50">
      <p class="font-bold text-gray-900 leading-relaxed">{{ real.libelle }}</p>
    </td>
    <td class="px-4 py-6 text-center text-gray-500 font-medium border-r border-gray-50 italic whitespace-nowrap">
      {{ real.periode }}
    </td>
    <td v-for="(check, i) in real.competences" :key="i" class="px-2 py-6 border-r border-gray-50 last:border-r-0">
      <div v-if="check" class="flex justify-center">
         <span class="text-[#060b24] font-black text-xs"><i class="ph ph-check-circle text-lg text-[#00ba2b]"></i></span>
      </div>
      <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-200 mx-auto"></div>
    </td>
  </tr>
</tbody>
            </table>
          </div>
          <div class="p-6 bg-gray-50/30 border-t border-gray-100 flex flex-col items-center gap-4">
         <a href="https://penguin.tailc4a1d9.ts.net" class="flex items-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs font-light text-sm hover:bg-opacity-90 transition-all shadow-md">   
    <i class="ph ph-plus-circle text-base"></i>
    Ajouter des compétences
  </a>

  <div class="flex items-center gap-2 text-gray-400 max-w-md text-center">
    <i class="ph ph-shield-check text-lg text-blue-600"></i>
    <p class="text-[9px] leading-relaxed italic lowercase font-light">
      l'ajout des compétences est accessible uniquement aux personnes habilitées à le faire pour des raisons de sécurité et d'intégrité des données professionnelles.
    </p>
  </div>
</div>
        </div>
      </div>

      <div class="lg:col-span-3 space-y-6">
        
        <div class="bg-white rounded border border-gray-200 shadow-sm sticky top-8">
          <div class="p-4 border-b border-gray-100">
            <h3 class="font-light text-gray-800 text-sm flex items-center gap-2">
              <i class="ph ph-folder-open text-[#060b24] text-xl"></i> Preuves & Documents
            </h3>
          </div>
          <div class="p-3 space-y-2">
            <div v-for="doc in docs" :key="doc.id" class="p-3 rounded-xs border-transparent hover:border-gray-200 hover:bg-[#f3f4f6] transition-all">
             <div class="flex items-center gap-3">
             <i class="ph ph-file-pdf text-2xl text-red-700"></i>
           <div class="flex-1 min-w-0">
           <h4 class="text-xs font-bold text-gray-900 truncate">{{ doc.nom }}</h4>
      
         <div class="flex items-center gap-3 mt-1">
          <router-link :to="doc.path" class="text-[10px] font-bold text-blue-600 hover:underline flex items-center gap-1">
          <i class="ph ph-eye"></i> Consulter
          </router-link>

           <span class="text-gray-300">|</span>

            <a :href="doc.lien" download class="text-[10px] font-light text-gray-500 hover:text-red-700 flex items-center gap-1">
          <i class="ph ph-download-simple"></i> PDF
          </a>
        </div>
      
      <p class="text-[9px] text-gray-400 mt-1 uppercase tracking-tighter italic">Mis à jour le {{ doc.date }}</p>
    </div>
  </div>
  
</div>

          </div>
        </div>
      </div>

    </div>


<div v-if="showExcelPreview" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
  <div class="bg-white w-full max-w-6xl h-[90vh] rounded-xs shadow-2xl flex flex-col overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
      <div class="flex items-center gap-2">
        <i class="ph ph-file-xls text-[#1d6f42] text-2xl"></i>
        <h3 class="font-bold text-gray-800">Aperçu du Tableau de Synthèse (Excel)</h3>
      </div>
      <button @click="showExcelPreview = false" class="text-gray-400 hover:text-red-500 transition-colors">
        <i class="ph-bold ph-x text-xl"></i>
      </button>
    </div>

    <div class="flex-1 bg-gray-100 relative">
      <iframe 
      title="Visualisation du tableau de synthèse des compétences"
  :src="'https://view.officeapps.live.com/op/view.aspx?src=' + encodeURIComponent('https://www.ezechielkouakou.fr/docs/classeur_competences.xlsx')" 
  class="w-full h-full border-none"
  allowfullscreen>
</iframe>
    </div>

    <div class="p-4 bg-gray-50 border-t border-gray-100 text-right">
      <button @click="showExcelPreview = false" class="px-6 py-2 bg-[#060b24] text-white rounded-xs font-light text-xs hover:bg-opacity-90">
        Fermer l'aperçu
      </button>
    </div>
  </div>
</div>


    
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// --- AJOUT : Date dynamique du jour ---
const dateAujourdhui = new Date().toLocaleDateString('fr-FR', {
  day: 'numeric',
  month: 'long',
  year: 'numeric'
});

const heureActuelle = new Date().toLocaleTimeString('fr-FR', {
  hour: '2-digit',
  minute: '2-digit'
});

const miseAjourTotale = ref(`${dateAujourdhui} à ${heureActuelle}`);
// --------------------------------------

const skillLabelsFull = [
  "Gérer le patrimoine informatique",
  "Répondre aux incidents",
  "Développer la présence en ligne",
  "Travailler en mode projet",
  "Mettre à disposition un service",
  "Organiser son développement pro"
];

const profile = ref({ nom: '', candidat: '', option: 'SISR', url: '' });
const realisations = ref([]);

// Modifié pour inclure la date dynamique dans les documents si besoin
const docs = ref([
  { id: 1, nom: "Compétence - 01", path: "/doc/competence01", lien: "/docs/Competence01.pdf", date: dateAujourdhui },
  { id: 2, nom: "Compétence - 07", path: "/doc/competence07", lien: "/docs/architecture.pdf", date: dateAujourdhui },
  { id: 3, nom: "Compétence - 11", path: "/doc/competence11", lien: "/assets/certificat.pdf", date: dateAujourdhui },
  { id: 4, nom: "Compétence - 14", path: "/doc/competence14", lien: "/docs/Competence14.pdf", date: dateAujourdhui },
  { id: 5, nom: "Compétence - 17", path: "/doc/competence17", lien: "/docs/Competence17.pdf", date: dateAujourdhui }
]);

const fetchData = async () => {
  try {
    const response = await fetch('https://penguin.tailc4a1d9.ts.net/api/get_data.php');
    const data = await response.json();
    if (data.success) {
      profile.value = {
        nom: data.profile.nom,
        candidat: data.profile.candidat,
        option: data.profile.option_bts,
        url: data.profile.url_portfolio
      };
      realisations.value = data.realisations;
    }
  } catch (e) {
    console.error("Erreur de connexion", e);
  }
};

const imprimerPage = () => {
  window.print();
};

const showExcelPreview = ref(false); 
const loading = ref(false); // Ajoute cette ligne si tu veux utiliser le spinner

onMounted(fetchData);
</script>
<style scoped>
/* IMPORTATION DE TOUS LES STYLES (au lieu de juste 'bold') */
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
/* @import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/bold/style.css"); */

/* Appliquer la police à tout le composant proprement */
.min-h-screen {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}

@media print {
  .lg\:col-span-3, button { display: none !important; }
  .lg\:col-span-9 { width: 100% !important; grid-column: span 12 / span 12 !important; }
  .max-w-\[1400px\] { max-width: 100% !important; }
  .bg-\[#f3f2ef\] { background: white !important; }
}
</style>