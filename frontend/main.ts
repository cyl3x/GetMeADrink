import 'vite/modulepreload-polyfill';
import bootstrap from 'bootstrap';
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
