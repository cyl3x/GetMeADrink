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
import AdminProductDetailPage from '@/pages/admin/product/AdminProductDetailPage.vue';
import AdminCategoryDetailPage from '@/pages/admin/category/AdminCategoryDetailPage.vue';
import AdminVariantListingPage from '@/pages/admin/variant/AdminVariantListingPage.vue';
import AdminVariantDetailPage from '@/pages/admin/variant/AdminVariantDetailPage.vue';

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
            {
                name: 'admin.order',
                path: 'order/:id',
                component: null,
            },

            {
                name: 'admin.products',
                path: 'products',
                component: AdminProductsListingPage,
            },
            {
                name: 'admin.product',
                path: 'product/:id?',
                component: AdminProductDetailPage,
            },

            {
                name: 'admin.categories',
                path: 'categories',
                component: AdminCategoriesListingPage,
            },
            {
                name: 'admin.category',
                path: 'category/:id?',
                component: AdminCategoryDetailPage,
            },

            {
                name: 'admin.variants',
                path: 'variants',
                component: AdminVariantListingPage,
            },
            {
                name: 'admin.variant',
                path: 'variant/:id?',
                component: AdminVariantDetailPage,
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
