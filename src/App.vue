<script setup>
import Chatwidget from './components/Chatwidget.vue'
</script>

<template>
  <div class="min-h-screen bg-white dark:bg-black transition-colors duration-500">
    <router-view />
    <Chatwidget />
  </div>
</template>

<style>
body {
  margin: 0;
  background-color: transparent !important; 
}
html {
  background-color: white;
}
html.dark {
  background-color: black; 
}
</style>