<template>
  <!-- BOUTON FLOTTANT -->
  <Transition name="chat-toggle">
    <button
      v-if="!isOpen"
      @click="openChat"
      class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-transparent hover:bg-transparent dark:bg-white dark:hover:bg-white rounded-full shadow-xl/20 flex items-center justify-center transition-all hover:scale-105"
      aria-label="Ouvrir l'assistant"
    >
     <img src="../assets/icon-chat-png.png" alt="Logo MyChat" class="w-8 h-8 rounded-full object-cover" />
      <!-- <i class="ph ph-chat-circle-text text-4xl text-black dark:text-[#060b24]"></i> -->
      <span v-if="hasUnreadHint" class="absolute -top-1 -right-1 w-3 h-3 bg-blue-600 rounded-full border-2 border-white dark:border-black animate-pulse"></span>
    </button>
  </Transition>

  <!-- PANNEAU DE CHAT -->
  <Transition name="chat-panel">
    <div
      v-if="isOpen"
      class="fixed bottom-6 right-6 z-50 w-[92vw] max-w-[360px] h-[520px] bg-white dark:bg-transparent rounded-xs shadow-lg flex flex-col overflow-hidden"
      style="font-family: Verdana, Geneva, Tahoma, sans-serif;"
    >
      <!-- HEADER -->
      <div class="bg-black dark:bg-white px-4 py-3 flex items-center justify-between shrink-0 rounded-t-[14px]">
        <div class="flex items-center gap-2">
          <img src="../assets/icon-chat-png.png" alt="Logo MyChat" class="w-8 h-8 rounded-full object-cover" />
          <div>
            <p class="text-[0.975rem] font-black text-white dark:text-black capitalize tracking-widest">MyChat</p>
            <p class="text-[10px] text-gray-300 dark:text-gray-400 lowercase tracking-wide">release v0.1</p>
          </div>
        </div>
        <button @click="isOpen = false" aria-label="Fermer" class="text-gray-300 hover:text-white transition-colors">
          <i class="ph ph-x-circle text-[1.50rem] dark:text-black"></i>
        </button>
      </div>

      <!-- ZONE DE MESSAGES -->
      <div ref="messagesEl" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/50 dark:bg-black/40">
        <div v-for="(m, i) in messages" :key="i">
          <div :class="m.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
            <div
              :class="m.role === 'user'
                ? 'bg-black dark:bg-blue-700 text-white rounded-sm px-3 py-2 max-w-[80%] text-xs leading-relaxed shadow-lg'
                : 'bg-[#d2d9fc] dark:bg-[#1b2452] text-[#060b24] dark:text-[#d2d9fc] rounded-xs px-3 py-2 max-w-[85%] text-xs leading-relaxed shadow-xs'"
            >
              {{ m.text }}
            </div>
          </div>

          <!-- SUGGESTIONS APRÈS UNE RÉPONSE DU BOT -->
          <div v-if="m.role === 'bot' && m.suggestions?.length" class="flex flex-wrap gap-1.5 mt-2">
            <button
              v-for="(s, si) in m.suggestions"
              :key="si"
              @click="sendMessage(s)"
              class="text-[10px] text-blue-700 dark:text-[#00082e] border border-[#d2d9fc] dark:border-white bg-blue-50/60 dark:bg-white hover:bg-white dark:hover:bg-white px-2.5 py-1 rounded-sm transition-colors"
            >
              {{ s }}
            </button>
          </div>
        </div>

        <!-- INDICATEUR "EN TRAIN D'ÉCRIRE" -->
        <div v-if="isThinking" class="flex justify-start">
          <div class="bg-transparent dark:bg-[#1b2452] rounded-xs px-3 py-2.5 flex items-center gap-1">
            <span class="w-1.5 h-1.5 bg-[#060b24]/50 dark:bg-[#d2d9fc]/60 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
            <span class="w-1.5 h-1.5 bg-[#060b24]/50 dark:bg-[#d2d9fc]/60 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
            <span class="w-1.5 h-1.5 bg-[#060b24]/50 dark:bg-[#d2d9fc]/60 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
          </div>
        </div>
      </div>

      <!-- ZONE DE SAISIE -->
      <div class="border-t border-gray-100 dark:border-gray-800 p-3 shrink-0 bg-white dark:bg-[#0a0e1f]">
        <form @submit.prevent="handleSubmit" class="flex items-center gap-2">
          <input
            v-model="draft"
            type="text"
            placeholder="Posez votre question..."
            class="flex-1 text-xs border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#0f1428] text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-600 rounded-xs px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none"
            :disabled="isThinking"
          />
          <button
            type="submit"
            :disabled="isThinking || !draft.trim()"
            class="w-9 h-9 shrink-0 bg-black hover:bg-[#0d1638] dark:bg-white dark:hover:bg-white disabled:opacity-30 rounded-sm flex items-center justify-center transition-colors"
            aria-label="Envoyer"
          >
            <i class="ph ph-share-fat text-white dark:text-[#060b24] text-sm"></i>
            <!-- <i class="ph ph-paper-plane-tilt text-white dark:text-[#060b24] text-sm"></i> -->
          </button>
        </form>
        <p class="text-[8px] text-gray-400 dark:text-gray-600 mt-2 text-center lowercase tracking-tight">
          réponses générées à partir d'une base de données interne, sans IA générative
        </p>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, nextTick, watch, onBeforeUnmount } from 'vue';


const API_CHATBOT_URL = 'https://www.ezechielkouakou.fr/api_chatbot.php';

const isOpen = ref(false);
const hasUnreadHint = ref(true);
const isThinking = ref(false);
const draft = ref('');
const messagesEl = ref(null);

// Suggestions par défaut si le backend ne répond pas / au premier chargement
const fallbackSuggestions = [
  'Quelles sont tes compétences techniques ?',
  'Quelles expériences as-tu ?',
  'Comment te contacter ?',
  'Quelle est ta formation actuelle ?'
];

const messages = ref([
  {
    role: 'bot',
    text: "Salut 👋 Je peux répondre à quelques questions sur le parcours, les compétences et les projets d'Ezechiel. Choisis une suggestion ou écris directement ta question.",
    suggestions: fallbackSuggestions
  }
]);

const suspiciousPatterns = [
  /<\s*script/i,                     
  /<\/?[a-z][^>]{0,50}>/i,           
  /\bunion\b[\s\S]{0,30}\bselect\b/i, 
  /\bselect\b[\s\S]{0,30}\bfrom\b/i,  
  /\bdrop\s+table\b/i,
  /\binsert\s+into\b/i,
  /\bdelete\s+from\b/i,
  /<\?php/i,
  /\$\{[\s\S]*\}/,                    
  /javascript:/i,
  /\bon[a-z]+\s*=\s*["']/i,           
  /```/,                              
  /function\s*\([^)]*\)\s*\{/,
  /=>\s*\{/,
  /;\s*(rm|curl|wget)\s/i,
  /\.\.\/\.\.\//,                     
];

function looksLikeCode(text) {
  return suspiciousPatterns.some((re) => re.test(text));
}

const openChat = () => {
  isOpen.value = true;
  hasUnreadHint.value = false;
};

let savedScrollY = 0;

const lockBodyScroll = () => {
  savedScrollY = window.scrollY;
  document.body.style.position = 'fixed';
  document.body.style.top = `-${savedScrollY}px`;
  document.body.style.left = '0';
  document.body.style.right = '0';
  document.body.style.width = '100%';
};

const unlockBodyScroll = () => {
  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.left = '';
  document.body.style.right = '';
  document.body.style.width = '';
  window.scrollTo(0, savedScrollY);
};

watch(isOpen, (open) => {
  if (open) {
    lockBodyScroll();
  } else {
    unlockBodyScroll();
  }
});

onBeforeUnmount(() => {
  if (isOpen.value) {
    unlockBodyScroll();
  }
});

const scrollToBottom = async () => {
  await nextTick();
  if (messagesEl.value) {
    messagesEl.value.scrollTop = messagesEl.value.scrollHeight;
  }
};

const handleSubmit = () => {
  const text = draft.value.trim();
  if (!text) return;
  draft.value = '';

  if (looksLikeCode(text)) {
    messages.value.push({ role: 'user', text });
    messages.value.push({
      role: 'bot',
      text: "Ce message ressemble à du code ou à une tentative d'injection, je ne peux pas le traiter. Merci de reformuler ta question en langage naturel 🙂",
      suggestions: fallbackSuggestions
    });
    scrollToBottom();
    return; 
  }

  sendMessage(text);
};

const sendMessage = async (text) => {
  messages.value.push({ role: 'user', text });
  await scrollToBottom();

  isThinking.value = true;
  await scrollToBottom();

  try {
    const response = await fetch(API_CHATBOT_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ message: text })
    });

    const rawText = await response.text();
    let data;
    try {
      data = JSON.parse(rawText);
    } catch (parseErr) {
      console.error('[chatbot] réponse non-JSON reçue :', rawText);
      throw parseErr;
    }

    if (data.success) {
      messages.value.push({
        role: 'bot',
        text: data.answer,
        suggestions: data.suggestions || []
      });
    } else {
      messages.value.push({
        role: 'bot',
        text: data.answer || "Je n'ai pas trouvé de réponse précise à cette question. Tu peux essayer de la reformuler, ou choisir une suggestion ci-dessous.",
        suggestions: data.suggestions || fallbackSuggestions
      });
    }
  } catch (e) {
    console.error('[chatbot] erreur réseau ->', e);
    messages.value.push({
      role: 'bot',
      text: "Petit souci de connexion avec l'assistant. Réessaie dans un instant.",
      suggestions: fallbackSuggestions
    });
  } finally {
    isThinking.value = false;
    await scrollToBottom();
  }
};
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");

/* Ouverture / fermeture du panneau de chat */
.chat-panel-enter-active,
.chat-panel-leave-active {
  transition: opacity 1.25s cubic-bezier(0.16, 1, 0.3, 1),
              transform 1.25s cubic-bezier(0.16, 1, 0.3, 1);
  transform-origin: bottom right;
}
.chat-panel-enter-from,
.chat-panel-leave-to {
  opacity: 0;
  transform: translateY(12px) scale(0.94);
}
.chat-panel-enter-to,
.chat-panel-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}

/* Apparition / disparition du bouton flottant */
.chat-toggle-enter-active,
.chat-toggle-leave-active {
  transition: opacity 1.0s ease, transform 1.0s ease;
}
.chat-toggle-enter-from,
.chat-toggle-leave-to {
  opacity: 0;
  transform: scale(0.75);
}
.chat-toggle-enter-to,
.chat-toggle-leave-from {
  opacity: 1;
  transform: scale(1);
}
</style>