import 'vite/modulepreload-polyfill';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
import './main.css';

import { createApp } from 'vue';
import App from '@/App.vue';
import { createPinia } from 'pinia';
import { createRouter } from 'vue-router';
import router from './router';

createApp(App)
    .use(createPinia())
    .use(createRouter(router))
    .mount('#app');
