import TablesPage from '@/pages/TablesPage.vue';
import OrderPage from '@/pages/OrderPage.vue';
import { createWebHistory } from 'vue-router';

const routes = [
    {
        name: 'tables',
        path: '/',
        component: TablesPage,
    },
    {
        name: 'order',
        path: '/order/:id',
        component: OrderPage,
    },
];

export default {
    history: createWebHistory(),
    routes,
};
