import './bootstrap';

import { createApp } from 'vue';

import router from './router'
import App from './app.vue';

const app = createApp({});

app.component("app-component", App); // register component globally

app.use(router).mount('#app'); // mount the app to the DOM