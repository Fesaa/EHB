<script setup lang="ts">

import {inject, onMounted, onUnmounted, ref} from "vue";
import type {Websocket} from "websocket-ts";
import {WebsocketEvent} from "websocket-ts";
import router from "@/router";

const props = defineProps(['initial_request', 'names']);
let serviceName = ref<string>('');
let sessionId = ref<string>('');
let services = ref<any[]>([]);

function handleWSAddClient(data: any) {
  if (props.names != null && !props.names.includes(data.client.name)) {
    return;
  }
  services.value.push(data.client);

  const tempRow = document.getElementById('temp-row');
  tempRow!.style.display = 'none';

}

function handleWSRemoveClient(data: any) {
  if (props.names != null && !props.names.includes(data.client.name)) {
    return;
  }
  for (let i = 0; i < services.value.length; i++) {
    const service = services.value[i];
    if (service.sessionId == data.client.sessionId) {
      service.active = false;
      break;
    }
  }

  if (services.value.length == 0) {
    const tempRow = document.getElementById('temp-row');
    tempRow!.innerHTML = '<th>No services found...</th>'
    tempRow!.style.display = 'flex';
  }
}

function handleWSClientList(data: any) {
  services.value = data.clients;
  const tempRow = document.getElementById('temp-row');

  if (services.value.length > 0) {
    tempRow!.style.display = 'none';
  } else {
    tempRow!.innerHTML = '<th>No services found...</th>'
  }
}

function overviewListener(i: Websocket, ev: MessageEvent) {
  const data = JSON.parse(ev.data);

  switch (data.type.toString().toLowerCase()) {
    case 'register_client':
      handleWSAddClient(data)
      break;
    case 'unregister_client':
      handleWSRemoveClient(data)
      break;
    case 'clientlist':
      handleWSClientList(data)
      break;
  }
}

onMounted(() => {
  const socket: Websocket | undefined = inject('websocket')
  if (socket == undefined) return;
  socket.send(props.initial_request)

  socket.addEventListener(WebsocketEvent.message, overviewListener)
})

onUnmounted(() => {
  const socket: Websocket | undefined = inject('websocket')
  if (socket == undefined) return;
  socket.removeEventListener(WebsocketEvent.message, overviewListener)
})

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

function goToServiceView(name: string) {
  router.push({name: 'service-overview', params: {name: name}})
}

</script>

<template>
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

    <tr v-for="service in services" :key="service.sessionId" class="data-row" :id="service.sessionId">
      <td @click="goToServiceView(service.name)">{{service.active ? "✅" : "❌"}}</td>
      <td @click="goToServiceView(service.name)">{{service.name}}</td>
      <td @click="goToServiceView(service.name)">{{service.sessionId}}</td>
      <td><router-link :to="{ name: 'session-details', params: { name: service.name, id: service.sessionId } }">View</router-link></td>
    </tr>

  </table>

  </div>
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