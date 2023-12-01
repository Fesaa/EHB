<script setup lang="ts">
import router from "@/router";
import {inject, onMounted, Ref, ref} from "vue";
import {Websocket, WebsocketEvent} from "websocket-ts";
import MyChart from "@/components/MyChart.vue";
import {ChartData} from "chart.js";
import {formatRelativeTime} from "@/utils";

const name = router.currentRoute.value.params.name
const session = router.currentRoute.value.params.id

type field = {
  name: string,
  value: string
}

let commitMutableFields: ((arg0: MouseEvent) => void) | undefined

const fields: Ref<field[]> = ref([])
const mutableFields: Ref<field[]>  = ref([])
const pingTimes: Ref<{time: number, ping: number}[]> = ref([])

function toDataSet(data: {time: number, ping: number}[]): ChartData<'line'> {
  const now = Date.now()
  return {
    labels: data.map((d) => formatRelativeTime((now - d.time)/1000)),
    datasets: [
      {
        label: 'ping',
        data: data.map((d) => d.ping),
        borderColor: 'rgba(18, 97, 128, 0.5)',
        backgroundColor: 'rgba(18, 97, 128 0.1)',
        fill: false
      }
    ]
  }

}

function updateFieldValue(field: field, $event: any) {
  field.value = $event.target.innerText
}

function loadClientInfo(msg: any) {
  const clientInfo = msg.info
  if (clientInfo.config) {
    fields.value = clientInfo.config.fields
    mutableFields.value = clientInfo.config.mutableFields
  }
  pingTimes.value = clientInfo.pings
}

function listener(i: Websocket, ev: MessageEvent) {
  const msg = JSON.parse(ev.data)
  if (msg.type == 'clientInfo') {
    loadClientInfo(msg)

    i.removeEventListener(WebsocketEvent.message, listener)
  }
}

function onNewPing(i: Websocket, ev: MessageEvent) {
  const msg = JSON.parse(ev.data)
  if (msg.type == 'ping_response' && session == msg.client.sessionId) {
    pingTimes.value.push({time: msg.time, ping: msg.ping})
  }
}

onMounted(() => {
  const ws: WebSocket | undefined = inject('websocket')
  if (ws == undefined) return;

  ws.addEventListener(WebsocketEvent.message, listener)
  ws.addEventListener(WebsocketEvent.message, onNewPing)

  ws.send(JSON.stringify({'type': 'requestclientinfo', 'session': session, 'name': name}))

  commitMutableFields = (e: MouseEvent) => {
    console.log('committing mutable fields')
    const json = JSON.stringify({'type': 'requestconfigchange', 'session': session, 'name': name, 'config': mutableFields.value})
    ws.send(json)
  }

  setInterval(() => {
    if (pingTimes.value[pingTimes.value.length - 1].ping == 0) {
      pingTimes.value.pop()
    }
    pingTimes.value.push({time: Date.now(), ping: 0})
  }, 1000)
})

</script>

<template>

  <div>

    <div id="config">

      <div v-for="field in fields" :key="'field-' + field.name + '-' + field.value" class="field-holder">
          <span class="field-name">{{ field.name }}</span>
          <span class="field-value">{{ field.value }}</span>
      </div>

      <div v-for="field in mutableFields" :key="'field-' + field.name + '-' + field.value" class="field-holder">
        <span class="field-name">{{ field.name }}</span>
        <div class="field-value"
            contenteditable="true"
            @blur="updateFieldValue(field, $event)"
        >{{ field.value}}</div>
      </div>

      <button @click="commitMutableFields">commit</button>
    </div>

    <MyChart :data="toDataSet(pingTimes)" />

  </div>

</template>

<style scoped>

#config {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

.field-holder {
  display: flex;
  flex-direction: column;
  flex: 10%;
  padding: 2em;
}

.field-name {
  font-weight: lighter;
}

.field-value {
  border-bottom: 1px solid black;

  width: 200px;
}

</style>