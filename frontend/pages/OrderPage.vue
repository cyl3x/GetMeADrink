<template>
<div class='d-flex vh-100'>
    <order-details-view />
    <products-view />
</div>
</template>

<script setup lang="ts">
import { OrderService } from '@/services';
import { order } from '@/state';
import { useRoute } from 'vue-router';
import ProductsView from '@/views/ProductsView.vue';
import OrderDetailsView from '@/views/OrderDetailsView.vue';

const route = useRoute();
const orderId = Number(route.params.id);
const orderStore = order.useStore();

async function fetchOrder() {
    orderStore.order = await OrderService.getOrder(orderId);
}

if (orderStore.order?.id !== orderId)
    fetchOrder();
</script>
