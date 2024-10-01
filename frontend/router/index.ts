import Tables from '@/pages/TablesPage.vue';
import { createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: Tables,
    },
];

export default {
    history: createWebHistory(),
    routes,
};
