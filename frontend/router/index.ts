import { order } from '@/state';
import TablesPage from '@/pages/TablesPage.vue';
import OrderPage from '@/pages/OrderPage.vue';
import { createWebHashHistory } from 'vue-router';
import CategoriesView from '@/views/CategoriesView.vue';
import ProductsView from '@/views/ProductsView.vue';
import AdminPage from '@/pages/admin/AdminPage.vue';
import AdminOrdersListingPage from '@/pages/admin/order/AdminOrdersListingPage.vue';
import AdminProductsListingPage from '@/pages/admin/product/AdminProductsListingPage.vue';
import AdminCategoriesListingPage from '@/pages/admin/category/AdminCategoriesListingPage.vue';
import AdminTablesListingPage from '@/pages/admin/table/AdminTablesListingPage.vue';

const routes = [
    {
        name: 'tables',
        path: '/',
        component: TablesPage,
        beforeEnter: () => order.useStore().order = null,
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
        name: 'admin',
        path: '/admin',
        component: AdminPage,
        redirect: { name: 'admin.orders' },
        children: [
            {
                name: 'admin.orders',
                path: 'orders',
                component: AdminOrdersListingPage,
            },
            // {
            //     name: 'admin.order.edit',
            //     path: 'order/:id/edit',
            //     component: ,
            // },
            // {
            //     name: 'admin.order.create',
            //     path: 'order/create',
            //     component: ,
            // },

            {
                name: 'admin.products',
                path: 'products',
                component: AdminProductsListingPage,
            },

            {
                name: 'admin.categories',
                path: 'categories',
                component: AdminCategoriesListingPage,
            },

            {
                name: 'admin.tables',
                path: 'tables',
                component: AdminTablesListingPage,
            },
        ],
    },
];

export default {
    history: createWebHashHistory(),
    routes,
};
