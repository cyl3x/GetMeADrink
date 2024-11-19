<template>
<div class='d-flex h-100 overflow-hidden'>
    <order-details-view />
    <page-loader-view v-if='categoriesStore.categories === null'>
        Lade Produkte...
    </page-loader-view>

    <router-view v-else />
</div>
</template>

<script setup lang="ts">
import { ProductService, OrderService } from '@/services';
import { categories, order } from '@/state';
import { useRoute } from 'vue-router';
import OrderDetailsView from '@/views/OrderDetailsView.vue';
import PageLoaderView from '../components/PageLoaderComponent.vue';

const route = useRoute();
const orderId = Number(route.params.id);
const orderStore = order.useStore();
const categoriesStore = categories.useStore();

async function fetchOrder() {
    orderStore.order = await OrderService.getOrder(orderId);
}

async function fetchCategories() {
    categoriesStore.setCategories(await ProductService.getCategories());
}

if (orderStore.order?.id !== orderId)
    fetchOrder();

if (categoriesStore.categories === null)
    fetchCategories();
</script>
