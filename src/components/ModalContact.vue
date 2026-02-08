<template>
  <Transition name="slide-up">
    <div v-if="isOpen" class="fixed inset-0 z-[10000] flex items-end justify-center">
      <div @click="$emit('close')" class="absolute inset-0 bg-black/80 backdrop-blur-xl"></div>

      <div class="relative w-full bg-white dark:bg-[#000000] border-t border-zinc-200 dark:border-white/10 rounded-t-[3rem] h-[80vh] md:h-[85vh] shadow-2xl overflow-hidden transition-colors duration-500">
        
        <div @click="$emit('close')"
          class="absolute top-6 left-1/2 -translate-x-1/2 w-16 h-1.5 bg-zinc-200 dark:bg-zinc-800 rounded-full cursor-pointer hover:bg-zinc-400 dark:hover:bg-zinc-600 transition-colors z-10">
        </div>

       <Transition name="fade">
  <div v-if="showSuccessMessage"
    class="absolute inset-0 z-50 flex items-center justify-center bg-white dark:bg-black transition-colors duration-500">
    <div class="text-center p-8 scale-in">
      <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      
      <h3 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2 tracking-tighter">Super !</h3>
      <p class="text-zinc-600 dark:text-zinc-400 font-medium max-w-xs mx-auto">{{ serverMessage }}</p>

      <p class="flex items-center justify-center gap-2 text-zinc-400 dark:text-zinc-500 text-sm mt-6 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock">
          <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        Vos données sont entre de bonnes mains.
      </p>

      <button @click="$emit('close')"
        class="mt-8 px-8 py-3 border border-zinc-200 dark:border-white/10 rounded-full text-sm font-bold text-zinc-900 dark:text-white hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
        Fermer
      </button>
    </div>
  </div>
</Transition>
        <div class="max-w-5xl mx-auto p-8 pt-16 h-full flex flex-col content-fade">
          <h2 class="text-4xl font-light mb-10 text-center text-black dark:text-white capitalize tracking-tighter transition-colors duration-500">
            Parlons de votre projet<span class="text-blue-500"></span>
          </h2>

          <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-8 overflow-y-auto pr-4 custom-scrollbar pb-10">
            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Vous êtes ?</label>
              <div class="grid grid-cols-2 gap-4">
                <button type="button" @click="form.role = 'particulier'"
                  :class="form.role === 'particulier' 
                    ? 'border-black bg-black text-white dark:border-white dark:bg-white dark:text-black' 
                    : 'border-zinc-200 text-zinc-500 dark:border-white/10 dark:text-white'"
                  class="py-3 border rounded-xl text-xs uppercase tracking-widest transition-all">
                  Particulier
                </button>
                <button type="button" @click="form.role = 'entreprise'"
                  :class="form.role === 'entreprise' 
                    ? 'border-black bg-black text-white dark:border-white dark:bg-white dark:text-black' 
                    : 'border-zinc-200 text-zinc-500 dark:border-white/10 dark:text-white'"
                  class="py-3 border rounded-xl text-xs uppercase tracking-widest transition-all">
                  Entreprise
                </button>
              </div>
            </div>

            <div v-if="form.role === 'entreprise'" class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Nom de l'entreprise</label>
              <input v-model="form.entreprise" type="text" required class="contact-input" placeholder="Ex: Google, Inc..." />
            </div>

            <div class="flex flex-col gap-3">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Nom</label>
              <input v-model="form.lastname" type="text" required class="contact-input" placeholder="Votre nom" />
            </div>

            <div class="flex flex-col gap-3">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Prénom</label>
              <input v-model="form.firstname" type="text" required class="contact-input" placeholder="Votre prénom" />
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Email</label>
              <input v-model="form.email" type="email" required class="contact-input" placeholder="email@exemple.com" />
            </div>

            <div class="flex flex-col gap-3 md:col-span-2">
              <label class="text-[10px] font-light uppercase tracking-[0.3em] text-zinc-400 dark:text-white/50 ml-2">Message</label>
              <textarea v-model="form.message" rows="4" required class="contact-input resize-none" placeholder="Décrivez votre projet..."></textarea>
            </div>

            <div class="md:col-span-2 pt-6">
              <button :disabled="loading" type="submit"
                class="w-full py-5 bg-black dark:bg-white hover:bg-zinc-800 dark:hover:bg-zinc-200 text-white dark:text-black font-bold text-sm uppercase tracking-widest rounded-2xl transition-all duration-300 disabled:opacity-30 flex items-center justify-center gap-3">
                <span v-if="loading" class="w-4 h-4 border-2 border-white/20 border-t-white dark:border-black/20 dark:border-t-black rounded-full animate-spin"></span>
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
const serverMessage = ref("");

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
  try {
    const data = new FormData();
    data.append("role", form.role);
    data.append("entreprise", form.entreprise);
    data.append("nom", form.lastname);
    data.append("prenom", form.firstname);
    data.append("email", form.email);
    data.append("message", form.message);

    const response = await fetch("./traitment.php", {
      method: "POST",
      body: data,
    });

    const result = await response.json();

    if (result.success) {
      serverMessage.value = result.message;
      showSuccessMessage.value = true;

      Object.assign(form, {
        role: "particulier",
        entreprise: "",
        lastname: "",
        firstname: "",
        email: "",
        message: "",
      });

      // On laisse l'utilisateur profiter du message, ou il peut cliquer sur "Fermer"
      setTimeout(() => {
        if (showSuccessMessage.value) {
          showSuccessMessage.value = false;
          emit("close");
        }
      }, 5000);
    } else {
      alert("Erreur : " + result.message);
    }
  } catch (error) {
    alert("Impossible de contacter le serveur.");
  } finally {
    loading.value = false;
  }
};
</script>
<style scoped>
/* Logique de nuance pour les inputs */
.contact-input {
  background-color: #f4f4f5; /* Zinc-100 en clair */
  border: 1px solid #e4e4e7; /* Zinc-200 */
  padding: 1.25rem;
  border-radius: 1.25rem;
  color: #18181b;
  font-size: 0.9rem;
  outline: none;
  transition: all 0.3s ease;
}

/* Version Dark des inputs */
.dark .contact-input {
  background-color: #0c0c0c;
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: white;
}

.contact-input:focus {
  border-color: #3b82f6;
  background-color: white;
}
.dark .contact-input:focus {
  background-color: #111;
  border-color: #3b82f6;
}

/* Custom scrollbar adaptative */
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e4e4e7; border-radius: 10px; }
.dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #333; }

/* Transitions existantes */
.fade-enter-active, .fade-leave-active { transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1); }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(20px); }
.scale-in { animation: scaleIn 0.4s ease-out; }

@keyframes scaleIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.slide-up-enter-active, .slide-up-leave-active { transition: transform 0.8s cubic-bezier(0.32, 0.72, 0, 1); }
.slide-up-enter-from, .slide-up-leave-to { transform: translateY(100%); }
</style>
