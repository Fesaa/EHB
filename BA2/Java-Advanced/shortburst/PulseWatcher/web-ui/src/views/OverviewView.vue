<script setup lang="ts">
import axios from "axios";
import {ref} from "vue";

let services = ref<any[]>([]);
let serviceName = ref<string>('');
let sessionId = ref<string>('');

function filterTable() {
  const table = document.getElementById('service-table');
  if (table) {
    const rows = table.getElementsByClassName('data-row');
    for (let i = 0; i < rows.length; i++) {
      const row = rows[i];
      const name = row.getElementsByTagName('td')[1];
      const session = row.getElementsByTagName('td')[2];
      if (name && session) {
        const nameText = name.innerText || name.textContent;
        const sessionText = session.innerText || session.textContent;
        if (nameText!.includes(serviceName.value) && sessionText!.includes(sessionId.value)) {
          row.setAttribute('style', 'display: ')
        } else {
          row.setAttribute('style', 'display: none')
        }
      }
    }
  }

}

function loadServices() {
  axios.get('http://127.0.0.1:8080/api/services')
      .then((resp) => {
        const tempRow = document.getElementById('temp-row');
        tempRow!.style.display = 'none';
        services.value = resp.data;
      })
      .catch((err) => {
        console.error(err);
      });
}

loadServices()

</script>

<template>
  <main style="display: flex; justify-content: center; flex-direction: column">
    <h1 style="flex: 1; text-align: center">Overview</h1>

    <div id="services">

      <div id="filter-holder">
        <div class="filter-cell">
          <label for="filter-name">Search by service name</label>
          <input type="text" id="filter-name" v-model="serviceName" @input="filterTable">
        </div>
        <div class="filter-cell">
          <label for="filter-name">Search by session id</label>
          <input type="text" id="filter-session" v-model="sessionId" @input="filterTable">
        </div>
        <div>
          <button @click="loadServices">Refresh</button>
        </div>
      </div>

      <table id="service-table" class="dashboard-table scrollable-table">
        <tr class="dashboard-table-header">
          <th>Active?</th>
          <th>Name</th>
          <th>Session ID</th>
          <th></th>
        </tr>
        <tr id="temp-row">
          <th>Waiting for data...</th>
        </tr>

        <tr v-for="service in services" :key="service.sessionId" class="data-row">
          <td>{{service.active ? "✅" : "❌"}}</td>
          <td>{{service.name}}</td>
          <td>{{service.sessionId}}</td>
          <td><a :href="'/service/' + service.name + '/' + service.sessionId + '/details'">View</a></td>
        </tr>

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