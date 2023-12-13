import './bootstrap';

import { createApp } from 'vue';
import router from './router'
import App from './app.vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUtensils } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const app = createApp({});

library.add(faUtensils);

app.component("app-component", App); // register component globally
app.component('font-awesome-icon', FontAwesomeIcon) // register fontawesome component globally

app.use(router);
app.use(ToastPlugin);

app.mount('#app'); // mount the app to the DOM