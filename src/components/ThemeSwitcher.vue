<script setup>
import { ref, onMounted } from 'vue'
import { PhSun, PhMoon } from '@phosphor-icons/vue'

const isDark = ref(true)

const toggleTheme = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.theme = 'dark'
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.theme = 'light'
  }
}

onMounted(() => {
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  } else {
    isDark.value = false
    document.documentElement.classList.remove('dark')
  }
})
</script>

<template>
  <button 
    @click="toggleTheme" 
    class="group relative flex items-center justify-center w-10 h-10 rounded-md bg-zinc-100 dark:bg-zinc-800/50   dark:border-white/10 transition-all duration-300 hover:border-blue-500 pointer-events-auto z-[100] shadow-sm hover:shadow-lg active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gray-500/30"
    aria-label="Toggle Theme"
  >
    <PhSun 
      v-if="isDark" 
      :size="20" 
      weight="regular"
      class="text-white-400 group-hover:text-white-600 transition-colors" 
    />
    <PhMoon 
      v-else 
      :size="20" 
      weight="regular"
      class="text-black group-hover:text-black-600 transition-colors" 
    />
  </button>
</template> 