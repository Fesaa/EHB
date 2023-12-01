<script setup lang="ts">
import router from "@/router";

const name = router.currentRoute.value.params.name
const session = router.currentRoute.value.params.id

</script>
<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <div style="margin: 2em">
      <div class="nav">
        <RouterLink :to="{ name: 'overview' }">Overview</RouterLink> › <RouterLink :to="{ name: 'service-overview', params: {name: name}}">{{ name }}</RouterLink> › {{ session }}
      </div>
      <div id="session-holder">
        <h3>{{ name }}</h3>

        <div id="session-info">
          <div id="session-nav">
            <ul>
              <li><RouterLink :to="{ name: 'session-details', params: { name: name, id: session } }">Details</RouterLink></li>
              <li><RouterLink :to="{ name: 'session-metrics', params: { name: name, id: session } }">Metrics</RouterLink></li>
            </ul>
          </div>

          <RouterView />
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>

#session-nav {
  background: rgba(0, 0, 0, 0.1);
  padding: 0.25em;
  border-radius: 0.5em;

  border-bottom: 2px solid rgb(128, 128, 128);
}

#session-nav > ul {
  display: flex;
  flex-direction: row;
  justify-content: left;

  list-style-type: none;
}

#session-nav > ul > li {
  margin-right: 5em;

  font-size: 1em;
}

#session-nav > ul > li > a {
  text-decoration: none;
  color: rgba(0, 0, 0, 0.75);
}

</style>