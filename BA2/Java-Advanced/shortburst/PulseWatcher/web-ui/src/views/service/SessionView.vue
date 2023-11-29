<script setup lang="ts">
import router from "@/router";

const name = router.currentRoute.value.params.name
const session = router.currentRoute.value.params.id

</script>

<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <h1 style="flex: 1; text-align: center">{{ name }} - {{ session}}</h1>
  </main>
</template>

<style scoped>

</style>