import './bootstrap';

import { createApp } from 'vue';
import router from './router'
import App from './app.vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const app = createApp({});

app.component("app-component", App); // register component globally

app.use(router);
app.use(ToastPlugin);

app.mount('#app'); // mount the app to the DOM