<script setup lang="ts">
import ServiceTable from "@/components/ServiceTable.vue";
</script>

<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <h1 style="flex: 1; text-align: center">Overview</h1>
    <ServiceTable :initial_request="JSON.stringify({'type': 'requestClientList'})"></ServiceTable>
  </main>
</template>

<style scoped>

</style>