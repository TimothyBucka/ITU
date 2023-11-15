import './bootstrap';

import { createApp } from 'vue';
import router from './router'

import App from './app.vue';
import navbar from "./views/navbar.vue"

const app = createApp({});

app.component("nav-component", navbar); // register component globally
app.component("app-component", App); // register component globally

app.use(router).mount('#app'); // mount the app to the DOM