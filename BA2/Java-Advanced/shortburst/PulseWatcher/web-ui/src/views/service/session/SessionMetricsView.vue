<script setup lang="ts">
import router from "@/router";
import {inject, onMounted, ref} from "vue";
import {Websocket, WebsocketEvent} from "websocket-ts";

const name = router.currentRoute.value.params.name
const session = router.currentRoute.value.params.id

const info = ref({})
const metrics = ref({})

function loadClientInfo(msg: any) {
  console.log(msg)

  const clientInfo = msg.info
  info.value = clientInfo.info
  metrics.value = clientInfo.metrics
}

function listener(i: Websocket, ev: MessageEvent) {
  const msg = JSON.parse(ev.data)
  if (msg.type == 'clientInfo') {
    loadClientInfo(msg)

    i.removeEventListener(WebsocketEvent.message, listener)
  }
}

onMounted(() => {
  const ws: WebSocket | undefined = inject('websocket')
  if (ws == undefined) return;

  ws.addEventListener(WebsocketEvent.message, listener)
  ws.send(JSON.stringify({'type': 'requestclientinfo', 'session': session, 'name': name}))
})


</script>

<template>
  <h1>METRICS</h1>

  <div id="info">

    <div v-for="(key, value) in info" :key="key" class="info-holder">
      <span class="info-name">{{ value }}</span>
      <span class="info-value">{{ key }}</span>
    </div>

  </div>

</template>

<style scoped>

#info {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.info-holder {
  display: flex;
  flex-direction: column;
  flex: 10%;
  padding: 2em;
}

.info-name {
  font-weight: lighter;
}

.info-value {
  border-bottom: 1px solid black;

  width: 200px;
}


</style>