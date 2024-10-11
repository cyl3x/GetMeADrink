<template>
<div
    class='fixed-left overflow-y-scroll p-3 bg-light shadow d-flex flex-column gap-4'
    style='min-width: 300px;'
>
    <div>
        <button
            class='d-flex btn btn-primary w-100 justify-content-center'
            @click='navigateToTables'
        >
            Tischübersicht
        </button>
    </div>

    <div v-if='orderStore.order != null'>
        <h4 class='justify-content-center'>
            Tisch {{ orderStore.order.table }}
        </h4>
    </div>

    <div v-if='pendingProductsStore.pending.size > 0'>
        <h5 class='pb-2 border-bottom border-dark'>
            Ausstehend
        </h5>
        <div class='order-product-grid'>
            <template
                v-for='{ product, quantity } in pendingProductsStore.pending.values()'
                :key='product.id'
            >
                <div>{{ quantity }}x</div>
                <div class='order-product-name'>
                    {{ product.name }}
                </div>
            </template>
        </div>
        <button class='btn btn-primary w-100 mt-2' @click='addPendingToOrder()'>
            Bestellen
        </button>
    </div>

    <div v-if='products.length > 0'>
        <h5 class='pb-2 pt-2 border-bottom border-dark'>
            Bestellung
        </h5>
        <div class='order-product-grid'>
            <template
                v-for='product in products'
                :key='product.id'
            >
                <div>{{ product.quantity }}x</div>
                <div class='order-product-name'>
                    {{ product.name }}
                </div>
                <div>{{ (product.price * product.quantity).toFixed(2) }} €</div>
            </template>
        </div>
    </div>

    <div v-if='orderStore.order' class='d-flex flex-column gap-3'>
        <button v-if='orderStore.order?.totalPrice!=0' class='btn btn-primary' @click='completeOrder()'>
            Zahlen: {{ orderStore.order.totalPrice.toFixed(2) }}€
        </button>
        <button class='btn btn-secondary' @click='cancelOrder()'>
            Abbrechen
        </button>
    </div>
</div>
</template>

<script setup lang='ts'>
import { OrderService } from '@/services';
import { order, pendingProducts } from '@/state';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const orderStore = order.useStore();
const pendingProductsStore = pendingProducts.useStore();

const products = computed(() => {
    if (!orderStore.order)
        return [];

    return orderStore.order.orderProducts.filter(product => product.quantity > 0);
});

async function addPendingToOrder(){
    if (!orderStore.order)
        throw new Error('No order available');

    const pendingProducts = pendingProductsStore.getIdQuantityObject();

    pendingProductsStore.pending.clear();

    orderStore.order = await OrderService.addProducts(orderStore.order.id, pendingProducts);
}

function navigateToTables() {
    router.push({ name: 'tables' });
    orderStore.order = null;
}

async function completeOrder() {
    if (!orderStore.order)
        throw new Error('No order available');

    await OrderService.completeOrder(orderStore.order?.id);
    orderStore.order = null;
    router.push({ name:'tables' });
}

async function cancelOrder(){
    if (!orderStore.order)
        throw new Error('No order available');

    await OrderService.cancelOrder(orderStore.order?.id);
    orderStore.order = null;
    router.push({ name:'tables' });
}
</script>

<style>
.order-product-grid {
    display: grid;
    grid-template-columns: 0.3fr 1fr 1fr;
    grid-column-gap: 0.5rem;
    grid-row-gap: 0.25rem;
    place-items: center end;
}

.order-product-name {
    place-self: center start;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
