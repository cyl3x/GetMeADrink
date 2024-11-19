import TablesPage from '@/pages/TablesPage.vue';
import OrderPage from '@/pages/OrderPage.vue';
import { createWebHashHistory } from 'vue-router';
import OrderListingPage from '@/pages/OrderListingPage.vue';
import CategoriesView from '@/views/CategoriesView.vue';
import ProductsView from '@/views/ProductsView.vue';

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
        redirect: { name: 'order.categories' },
        children: [
            {
                name: 'order.categories',
                path: '',
                component: CategoriesView,
            },
            {
                name: 'order.products',
                path: 'category/:categoryId?',
                component: ProductsView,
            },
        ],
    },
    {
        name: 'listing.orders',
        path: '/orders',
        component: OrderListingPage,
    },
];

export default {
    history: createWebHashHistory(),
    routes,
};
