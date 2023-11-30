import './assets/main.css'
import './assets/header.css'
import './assets/tables.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import {Websocket, WebsocketEvent} from "websocket-ts";

const webSocket = new Websocket("ws://localhost:8080/ws/webui")
const app= createApp(App)
app.provide('websocket', webSocket)

const echoOnMessage = (i: Websocket, ev: MessageEvent) => {
    console.log(`received message: ${ev.data}`);
};

// Add event listeners
webSocket.addEventListener(WebsocketEvent.open, () => console.log("opened!"));
webSocket.addEventListener(WebsocketEvent.close, () => console.log("closed!"));
webSocket.addEventListener(WebsocketEvent.message, echoOnMessage);

app.use(router)
app.provide('router', router)

app.mount('#app')