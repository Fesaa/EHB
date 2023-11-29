<script setup lang="ts">

</script>

<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <h1 style="flex: 1; text-align: center">Overview</h1>

    <div id="services">

      <div id="filter-holder">
        <div class="filter-cell">
          <label for="filter-name">Search by service name</label>
          <input type="text" id="filter-name">
        </div>
        <div class="filter-cell">
          <label for="filter-name">Search by session id</label>
          <input type="text" id="filter-session">
        </div>
      </div>

      <table class="dashboard-table scrollable-table">
        <tr class="dashboard-table-header">
          <th>Name</th>
          <th>Session ID</th>
          <th>Active</th>
          <th>Uptime</th>
          <th></th>
        </tr>
        Waiting for data...
      </table>
    </div>
  </main>
</template>

<style scoped>

#filter-holder {
  display: flex;
  flex-direction: row;
  flex: 1;

  width: 100%;
}

.filter-cell {
  display: flex;
  flex-direction: column;

  flex: 50% 1;

  margin-bottom: 2em;
}

.filter-cell > input {
  width: 90%;
  border: none;
  border-bottom: 1px solid black;
}

.filter-cell > input:hover {
  border: none;
  border-bottom: 2px solid green;
}

.filter-cell:hover {
  color: green;
}

#services {
  width: 97%;
  align-self: center;

  display: flex;
  flex-direction: column;
  align-items: center;

  padding: 1em;

  border: 1px solid lightslategray;
}

#services > table {
  width: 95%;
  margin-top: 1em;
  margin-bottom: 1em;
}

</style>