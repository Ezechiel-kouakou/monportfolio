<template>
  <div class="min-h-screen bg-white dark:bg-[#020617] transition-colors duration-500 pt-32 pb-20 px-6">
    <div class="max-w-5xl mx-auto relative">
      
      <router-link to="/" class="group flex items-center gap-2 text-zinc-400 hover:text-black dark:hover:text-white transition-colors mb-12 w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium">Retour à l'accueil</span>
      </router-link>

      <Transition name="fade">
        <div v-if="showSuccessMessage" 
             class="absolute inset-0 z-50 flex items-center justify-center bg-white dark:bg-[#020617] transition-colors duration-500">
          <div class="text-center scale-in flex flex-col items-center">
            <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-8">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h3 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3 tracking-tighter">C'est envoyé !</h3>
            <p class="text-zinc-500 dark:text-zinc-400 font-medium max-w-sm mx-auto leading-relaxed mb-10">
              Hey 👋 {{ lastFirstName }}, merci pour votre message. Je vous recontacte rapidement.
            </p>
            <button @click="showSuccessMessage = false" 
                    class="px-10 py-3 border border-zinc-200 dark:border-white/10 rounded-full text-sm font-bold text-zinc-900 dark:text-white hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
              Envoyer un autre message
            </button>
          </div>
        </div>
      </Transition>

      <div class="flex flex-col">
        <h2 class="text-5xl md:text-6xl font-bold mb-4 text-black dark:text-white tracking-tighter transition-colors duration-500">
          Parlons de votre projet.
        </h2>
        <p class="text-zinc-500 dark:text-zinc-400 mb-16 text-lg">
          Particulier ou entreprise, je suis à votre écoute pour vos besoins en développement et infrastructure.
        </p>

        <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-8">
          
          <div class="flex flex-col gap-3 md:col-span-2">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Vous êtes ?</label>
            <div class="grid grid-cols-2 gap-4 max-w-md">
              <button type="button" @click="form.role = 'particulier'"
                :class="form.role === 'particulier' ? 'bg-black text-white dark:bg-white dark:text-black border-transparent' : 'border border-zinc-200 dark:border-white/10 text-zinc-500 hover:border-zinc-400'"
                class="py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all">
                Particulier
              </button>
              <button type="button" @click="form.role = 'entreprise'"
                :class="form.role === 'entreprise' ? 'bg-black text-white dark:bg-white dark:text-black border-transparent' : 'border border-zinc-200 dark:border-white/10 text-zinc-500 hover:border-zinc-400'"
                class="py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all">
                Entreprise
              </button>
            </div>
          </div>

          <div v-if="form.role === 'entreprise'" class="flex flex-col gap-3 md:col-span-2">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Entreprise</label>
            <input v-model="form.entreprise" type="text" required class="p-5 border border-zinc-200 dark:border-white/10 rounded-2xl bg-transparent text-black dark:text-white outline-none focus:ring-2 ring-blue-500/20 transition-all" placeholder="Nom de l'entreprise" />
          </div>

          <div class="flex flex-col gap-3">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Nom</label>
            <input v-model="form.lastname" type="text" required class="p-5 border border-zinc-200 dark:border-white/10 rounded-2xl bg-transparent text-black dark:text-white outline-none focus:ring-2 ring-blue-500/20 transition-all" />
          </div>

          <div class="flex flex-col gap-3">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Prénom</label>
            <input v-model="form.firstname" type="text" required class="p-5 border border-zinc-200 dark:border-white/10 rounded-2xl bg-transparent text-black dark:text-white outline-none focus:ring-2 ring-blue-500/20 transition-all" />
          </div>

          <div class="flex flex-col gap-3 md:col-span-2">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Email Professionnel / Personnel</label>
            <input v-model="form.email" type="email" required class="p-5 border border-zinc-200 dark:border-white/10 rounded-2xl bg-transparent text-black dark:text-white outline-none focus:ring-2 ring-blue-500/20 transition-all" placeholder="votre@email.com" />
          </div>

          <div class="flex flex-col gap-3 md:col-span-2">
            <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 dark:text-white/30 ml-2">Votre Message</label>
            <textarea v-model="form.message" rows="6" required class="p-5 border border-zinc-200 dark:border-white/10 rounded-2xl bg-transparent text-black dark:text-white resize-none outline-none focus:ring-2 ring-blue-500/20 transition-all" placeholder="Décrivez votre projet en quelques mots..."></textarea>
          </div>

          <div class="md:col-span-2 pt-6">
            <button :disabled="loading" type="submit"
              class="w-full py-6 bg-black dark:bg-white text-white dark:text-black font-bold text-xs uppercase tracking-[0.2em] rounded-2xl transition-all duration-300 disabled:opacity-30 hover:shadow-xl hover:-translate-y-1 active:scale-[0.98]">
              {{ loading ? "Transmission en cours..." : "Lancer la connexion" }}
            </button>
          </div>
        </form>

        <div class="flex items-center justify-center gap-3 mt-12 opacity-40">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
          <span class="text-[10px] uppercase tracking-[0.25em] font-bold text-black dark:text-white text-center">
            Transmission sécurisée et confidentielle
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";

const loading = ref(false);
const showSuccessMessage = ref(false);
const lastFirstName = ref(""); 

const form = reactive({
  role: "particulier",
  entreprise: "",
  lastname: "",
  firstname: "",
  email: "",
  message: "",
});

const handleSubmit = async () => {
  loading.value = true;
  lastFirstName.value = form.firstname; 
  
  try {
    const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";
    const apiUrl = isLocal 
      ? "http://localhost/mon-portfolio/traitment.php" 
      : "/traitment.php";

    const response = await fetch(apiUrl, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json",
        "Accept": "application/json" 
      },
      body: JSON.stringify(form),
    });

    const result = await response.json();

    if (result.success) {
      showSuccessMessage.value = true;
      // Scroll vers le haut pour voir le message
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      Object.assign(form, { 
        role: "particulier", entreprise: "", lastname: "", 
        firstname: "", email: "", message: "" 
      });
    } else {
      throw new Error(result.message || "Erreur lors de l'envoi");
    }
  } catch (error) {
    alert("Désolé, une erreur est survenue : " + error.message);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.5s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.scale-in { animation: scaleIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes scaleIn { from { opacity: 0; transform: translateY(20px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
</style>