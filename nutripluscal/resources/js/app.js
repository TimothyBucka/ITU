import './bootstrap';
import router from './router';
import { createApp } from 'vue';
import App from './app.vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { OnClickOutside } from '@vueuse/components';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faUtensils, faPhone, faLocationDot } from '@fortawesome/free-solid-svg-icons';

const app = createApp({});

library.add(faUtensils, faPhone, faLocationDot);

// global components
app.component("app-component", App);
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('OnClickOutside', OnClickOutside);

app.use(router);
app.use(ToastPlugin);

app.mount('#app'); // mount the app to the DOM