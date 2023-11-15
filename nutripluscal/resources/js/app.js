import './bootstrap';

import { createApp } from 'vue';

import App from './vue/app.vue';
import DataTile from './vue/dataTile.vue';
import navbar from "./vue/navbar.vue";

//createApp(App).mount('#app');
const app = createApp({});

app.component("nav-component", navbar); // register component globally
app.component("app-component", App); // register component globally

app.mount('#app'); // mount the app to the DOM