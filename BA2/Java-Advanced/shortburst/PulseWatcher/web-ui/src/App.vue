<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header class="float shiny-float">
    <h1 class="name">
      <a class="rainbow-text">Pulse Watcher</a>
    </h1>
    <ul>
      <li class="nav-button secondary-button"><RouterLink to="/">Home</RouterLink></li>
      <li class="nav-button secondary-button"><RouterLink to="/overview">Services</RouterLink></li>
      <li class="nav-button secondary-button"><RouterLink to="/about">About</RouterLink></li>
    </ul>
  </header>

  <RouterView />
</template>

<style scoped>
</style>
