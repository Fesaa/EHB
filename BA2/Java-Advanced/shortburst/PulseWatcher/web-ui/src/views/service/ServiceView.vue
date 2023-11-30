<script setup lang="ts">

import router from "@/router";
import ServiceTable from "@/components/ServiceTable.vue";

const name = router.currentRoute.value.params.name
</script>

<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <div style="margin: 2em">
      <div class="nav">
        <RouterLink :to="{ name: 'overview' }">Overview</RouterLink> › {{ name }}
      </div>
      <div id="session-holder">
        <h1>{{ name }}</h1>
        <div>
          <ServiceTable :initial_request="JSON.stringify({'type': 'requestClientList', 'names': [name]})" :names="[name]" />
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>

</style>