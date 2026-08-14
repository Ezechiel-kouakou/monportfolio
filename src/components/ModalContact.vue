<template class="modale-container">
  <Transition name="slide-up">
    <div v-if="isOpen" class="fixed inset-0 z-[10000] flex items-end justify-center">
      <div @click="$emit('close')" class="absolute inset-0 bg-black/80 backdrop-blur-xl"></div>

      <div class="relative w-full bg-white dark:bg-[#000000] border-t border-zinc-200 dark:border-white/10 rounded-t-[3rem] h-[80vh] md:h-[85vh] shadow-2xl overflow-hidden transition-colors duration-500">
        
        <div @click="$emit('close')"
          class="absolute top-6 left-1/2 -translate-x-1/2 w-16 h-1.5 bg-zinc-200 dark:bg-zinc-800 rounded-full cursor-pointer hover:bg-zinc-400 dark:hover:bg-zinc-600 transition-colors z-10">
        </div>

        <Transition name="fade">
          <div v-if="showSuccessMessage"
            class="absolute inset-0 z-50 flex items-center justify-center bg-white dark:bg-black transition-colors duration-500 p-8">
            <div class="text-center scale-in flex flex-col items-center">
              
              <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
              </div>

              <h3 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3 tracking-tighter">C'est envoyé !</h3>
              
              <p class="text-zinc-500 dark:text-zinc-400 font-medium max-w-sm mx-auto leading-relaxed mb-10">
                Hey 👋 {{ lastFirstName }}, merci pour votre message. Je reviens vers vous dans les plus brefs délais pour échanger sur votre projet.
              </p>

              <button @click="$emit('close')" 
                class="px-10 py-3 border border-zinc-200 dark:border-white/10 rounded-full text-sm font-bold text-zinc-900 dark:text-white hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors mb-12">
                Fermer
              </button>

              <div class="flex items-center gap-2 opacity-30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-black dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span class="text-[9px] uppercase tracking-[0.25em] font-bold text-black dark:text-white">
                  Vos données sont entre de bonnes mains
                </span>
              </div>
            </div>
          </div>
        </Transition>

        <div class="max-w-5xl mx-auto p-8 pt-16 h-full flex flex-col">
          <h2 class="text-4xl font-light mb-10 text-center text-black dark:text-white capitalize tracking-tighter transition-colors duration-500">
            Parlons de votre projet
          </h2>

          <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-8 overflow-y-auto pr-4 custom-scrollbar pb-10">
            
            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Vous êtes ?</label>
              <div class="grid grid-cols-2 gap-4 ">
                <button type="button" @click="form.role = 'particulier'"
                  :class="form.role === 'particulier' ? 'bg-black text-white dark:bg-white dark:text-black' : ' border border-zinc-200 dark:border-white/10 text-zinc-500'"
                  class="py-3 rounded-sm text-xs capitalize tracking-widest transition-all inset-shadow-2xs">
                  Particulier
                </button>
                <button type="button" @click="form.role = 'entreprise'"
                  :class="form.role === 'entreprise' ? 'bg-black text-white dark:bg-white dark:text-black' : 'border border-zinc-200 dark:border-white/10 text-zinc-500'"
                  class="py-3 rounded-sm text-xs capitalize tracking-widest transition-all inset-shadow-2xs">
                  Entreprise
                </button>
              </div>
            </div>

            <div v-if="form.role === 'entreprise'" class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Entreprise</label>
              <input v-model="form.entreprise" type="text" required class="p-4  border-zinc-200 dark:border-white/10 rounded-sm bg-transparent text-black dark:text-white outline-none focus:border-zinc-400 transition-colors inset-shadow-sm" placeholder="Nom de votre entreprise" />
            </div>

            <div class="flex flex-col gap-3">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Nom</label>
              <input v-model="form.lastname" type="text" required class="p-4 border-zinc-200 dark:border-white/10 rounded-sm bg-transparent text-black dark:text-white outline-none focus:border-zinc-400 transition-colors inset-shadow-sm" />
            </div>

            <div class="flex flex-col gap-3">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Prénom</label>
              <input v-model="form.firstname" type="text" required class="p-4 border-zinc-200 dark:border-white/10 rounded-sm bg-transparent text-black dark:text-white outline-none focus:border-zinc-400 transition-colors inset-shadow-sm" />
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Email</label>
              <input v-model="form.email" type="email" required class="p-4 border-zinc-200 dark:border-white/10 rounded-sm bg-transparent text-black dark:text-white outline-none focus:border-zinc-400 transition-colors inset-shadow-sm" />
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Message</label>
              <textarea v-model="form.message" rows="4" required class="p-4 border-zinc-200 dark:border-white/10 rounded-sm bg-transparent text-black dark:text-white resize-none outline-none focus:border-zinc-400 transition-colors inset-shadow-sm"></textarea>
            </div>

            <div class="md:col-span-2 pt-6">
              <button :disabled="loading" type="submit"
                class="w-full py-5 bg-black dark:bg-white text-white dark:text-black font-bold text-sm uppercase tracking-widest rounded-2xl transition-all duration-300 disabled:opacity-30 hover:scale-[1.01] active:scale-[0.99]">
                {{ loading ? "Envoi en cours..." : "Envoyer le message" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { reactive, ref } from "vue";

defineProps(["isOpen"]);
const emit = defineEmits(["close"]);

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

    const contentType = response.headers.get("content-type");
    
    if (!response.ok || !contentType || !contentType.includes("application/json")) {
        const errorText = await response.text();
        console.error("Réponse du serveur (non-JSON) :", errorText);
        throw new Error("Le serveur n'a pas répondu au format JSON. Vérifiez que traitment.php est bien à la racine du serveur.");
    }

    const result = await response.json();

    if (result.success) {
      showSuccessMessage.value = true;
      setTimeout(() => {
        Object.assign(form, { 
          role: "particulier", 
          entreprise: "", 
          lastname: "", 
          firstname: "", 
          email: "", 
          message: "" 
        });
      }, 500);
    } else {
      throw new Error(result.message || "Erreur lors de l'envoi");
    }
  } catch (error) {
    console.error("Erreur détaillée :", error);
    alert("Désolé, une erreur est survenue : " + error.message);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.slide-up-enter-active, .slide-up-leave-active { transition: transform 0.6s cubic-bezier(0.32, 0.72, 0, 1); }
.slide-up-enter-from, .slide-up-leave-to { transform: translateY(100%); }
.fade-enter-active, .fade-leave-active { transition: opacity 0.4s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.scale-in { animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e4e4e7; border-radius: 10px; }
.dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; }
.modal-container,
input,
textarea,
button,
label,
h2,
h3,
p {
  font-family: Verdana, Geneva, Tahoma, sans-serif !important;
}

/* Garder les proportions et espacements pour un rendu propre */
h2 {
  font-weight: 800;
  letter-spacing: -0.02em;
}

label {
  font-weight: 300;
  letter-spacing: 0.05em;
}
</style>