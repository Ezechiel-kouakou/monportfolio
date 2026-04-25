<template>
  <div class="min-h-screen bg-zinc-50 dark:bg-[#020617] pt-24 pb-20 px-6 transition-colors duration-500">
    <div class="max-w-4xl mx-auto space-y-12">
      
      <section class="bg-white dark:bg-white/5 p-8 rounded-3xl border border-zinc-200 dark:border-white/10 shadow-sm">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold dark:text-white uppercase tracking-tighter text-black">Informations Étudiant</h2>
          <button @click="isEditingProfile = !isEditingProfile" class="text-xs font-bold text-blue-500 uppercase hover:underline">
            {{ isEditingProfile ? 'Annuler' : 'Modifier le profil' }}
          </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" :class="{'opacity-50 cursor-not-allowed': !isEditingProfile}">
          <div class="flex flex-col gap-2">
            <label class="label-style">Nom et Prénom</label>
            <input v-model="profile.nom" :disabled="!isEditingProfile" placeholder="Firdaous AMADOU" class="input-style">
          </div>
          <div class="flex flex-col gap-2">
            <label class="label-style">N° Candidat</label>
            <input v-model="profile.candidat" :disabled="!isEditingProfile" placeholder="Optionnel" class="input-style">
          </div>
          <div class="flex flex-col gap-2">
            <label class="label-style">Option BTS</label>
            <select v-model="profile.option" :disabled="!isEditingProfile" class="input-style bg-white dark:bg-[#020617]">
              <option value="SISR">SISR</option>
              <option value="SLAM">SLAM</option>
            </select>
          </div>
          <div class="flex flex-col gap-2">
            <label class="label-style">URL Portfolio</label>
            <input v-model="profile.url" :disabled="!isEditingProfile" placeholder="https://ton-portfolio.fr" class="input-style">
          </div>
        </div>
        
        <transition name="fade">
          <button v-if="isEditingProfile" @click="saveProfile" class="mt-6 w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition-all">
            Enregistrer les informations
          </button>
        </transition>
      </section>

      <section class="bg-white dark:bg-white/5 p-8 rounded-3xl border border-zinc-200 dark:border-white/10 shadow-sm">
        <h2 class="text-xl font-bold dark:text-white uppercase tracking-tighter mb-8 text-black">Nouvelle Réalisation Professionnelle</h2>
        
        <form @submit.prevent="addRealisation" class="space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
              <label class="label-style">Libellé de la réalisation</label>
              <textarea v-model="newReal.libelle" class="input-style h-32 resize-none" placeholder="Ex: Mise en place d'un serveur GLPI sur Azure avec documentation complète..."></textarea>
            </div>
            <div class="flex flex-col gap-2">
              <label class="label-style">Période</label>
              <input v-model="newReal.periode" type="text" class="input-style" placeholder="Ex: Janvier 2024">
            </div>
          </div>

          <div class="space-y-4">
            <label class="label-style">Compétences liées (Cocher les cases)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div v-for="(skill, i) in skillLabels" :key="i" 
                   @click="newReal.competences[i] = !newReal.competences[i]"
                   class="flex items-start gap-4 p-4 border rounded-2xl cursor-pointer transition-all duration-300"
                   :class="newReal.competences[i] ? 'border-black dark:border-white bg-zinc-100 dark:bg-white/10' : 'border-zinc-200 dark:border-white/5 opacity-60 hover:opacity-100'">
                
                <div class="mt-1 w-5 h-5 border-2 rounded flex-shrink-0 flex items-center justify-center transition-colors" 
                     :class="newReal.competences[i] ? 'bg-black dark:bg-white border-black dark:border-white' : 'border-zinc-300'">
                  <svg v-if="newReal.competences[i]" class="w-3 h-3 text-white dark:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                
                <span class="text-[11px] font-bold uppercase leading-tight dark:text-zinc-200 text-zinc-700">{{ skill }}</span>
              </div>
            </div>
          </div>

          <button type="submit" :disabled="loading" class="w-full py-5 bg-black dark:bg-white text-white dark:text-black font-bold rounded-2xl uppercase text-xs tracking-widest hover:scale-[1.01] active:scale-[0.99] transition-all disabled:opacity-50">
            {{ loading ? 'Envoi en cours...' : 'Ajouter au tableau de synthèse' }}
          </button>
        </form>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

const isEditingProfile = ref(false);
const loading = ref(false);
const skillLabels = [
  "Gérer le patrimoine informatique", 
  "Répondre aux incidents et aux demandes d’assistance", 
  "Développer la présence en ligne de l’organisation", 
  "Travailler en mode projet", 
  "Mettre à disposition un service informatique", 
  "Organiser son développement professionnel"
];

// URLs de ton API WAMP
const API_BASE = "http://localhost/api-portfolio";

const profile = reactive({ nom: '', candidat: '', option: 'SISR', url: '' });
const newReal = reactive({ 
  libelle: '', 
  periode: '', 
  competences: [false, false, false, false, false, false] 
});

// Charger les données existantes au démarrage
onMounted(async () => {
  try {
    const res = await fetch(`${API_BASE}/get_data.php`);
    const data = await res.json();
    if (data.profile) {
      Object.assign(profile, data.profile);
    }
  } catch (e) {
    console.warn("Profil vide ou serveur non démarré.");
  }
});

const saveProfile = async () => {
  try {
    const res = await fetch(`${API_BASE}/save_profile.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(profile)
    });
    if (res.ok) {
      isEditingProfile.value = false;
      alert("Profil mis à jour !");
    }
  } catch (e) {
    alert("Erreur lors de la sauvegarde.");
  }
};

const addRealisation = async () => {
  if (!newReal.libelle || !newReal.periode) return alert("Remplis le libellé et la période !");
  
  loading.value = true;
  try {
    const res = await fetch(`${API_BASE}/add_realisation.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(newReal)
    });
    
    if (res.ok) {
      alert("Réalisation ajoutée au tableau !");
      // Reset
      newReal.libelle = '';
      newReal.periode = '';
      newReal.competences = [false, false, false, false, false, false];
    }
  } catch (e) {
    alert("Erreur de connexion au serveur WAMP.");
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Remplacement des @apply pour Tailwind v4 / Vite */
.input-style {
  width: 100%;
  padding: 1rem;
  border: 1px solid rgba(0,0,0,0.1);
  border-radius: 1rem;
  background-color: transparent;
  font-size: 0.875rem;
  outline: none;
  transition: all 0.3s ease;
}

.dark .input-style {
  border-color: rgba(255,255,255,0.1);
  color: white;
}

.input-style:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.label-style {
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #a1a1aa;
  margin-left: 0.25rem;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>