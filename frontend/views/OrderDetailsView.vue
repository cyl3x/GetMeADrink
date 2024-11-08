<template>
<div
    class='fixed-left bg-light shadow d-flex flex-column'
    style='min-width: 300px;'
>
    <div class='overflow-y-scroll flex-grow-1 p-3'>
        <div v-if='pendingProductsStore.pending.size > 0'>
            <h5 class='pb-2 border-bottom border-dark'>
                Ausstehend
            </h5>
            <div class='pending-product-grid'>
                <template
                    v-for='{ product, quantity } in pendingProductsStore.pending.values()'
                    :key='product.id'
                >
                    <div>{{ quantity }}x</div>
                    <div class='order-product-name'>
                        {{ product.name }} | {{ product.variant.name }}
                    </div>
                </template>
            </div>

            <button
                :disabled='loading'
                class='btn btn-warning w-100 mt-2'
                @click='addPendingToOrder()'
            >
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
                        {{ product.name }} | {{ product.variantName }}
                    </div>
                    <div>{{ (product.price * product.quantity).toFixed(2) }} €</div>
                </template>
            </div>
        </div>
    </div>

    <div class='border-top border-1 border-secondary' />

    <div class='p-3'>
        <button
            :disabled='loading || !orderStore.order || orderStore.order.orderProducts.length === 0'
            class='btn btn-success w-100'
            @click='completeOrder()'
        >
            <span
                v-if='loadingState.complete'
                class='spinner-border spinner-border-sm'
            />
            Zahlen:
            <span
                v-if='loadingState.addProducts'
                class='spinner-border spinner-border-sm'
            />
            <template v-else>
                {{ (orderStore.order?.totalPrice ?? 0).toFixed(2) }}
            </template>
            €
        </button>

        <button
            :disabled='loading || !orderStore.order'
            class='btn btn-secondary w-100 mt-3'
            @click='cancelOrder()'
        >
            <span
                v-if='loadingState.cancel'
                class='spinner-border spinner-border-sm'
            />
            Abbrechen
        </button>
    </div>
</div>
</template>

<script setup lang='ts'>
import { OrderService } from '@/services';
import { order, pendingProducts } from '@/state';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const orderStore = order.useStore();
const pendingProductsStore = pendingProducts.useStore();
const loadingState = ref({
    addProducts: false,
    complete: false,
    cancel: false,
});
const loading = computed(() => loadingState.value.addProducts || loadingState.value.complete || loadingState.value.cancel);

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

    loadingState.value.addProducts = true;
    orderStore.order = await OrderService.addProducts(orderStore.order.id, pendingProducts)
        .finally(() => loadingState.value.addProducts = false);
}

async function completeOrder() {
    if (!orderStore.order)
        throw new Error('No order available');

    loadingState.value.complete = true;

    await OrderService.completeOrder(orderStore.order?.id)
        .catch(() => loadingState.value.complete = false);

    orderStore.order = null;

    router.push({ name:'tables' });
}

async function cancelOrder(){
    if (!orderStore.order)
        throw new Error('No order available');

    loadingState.value.cancel = true;

    await OrderService.cancelOrder(orderStore.order?.id)
        .catch(() => loadingState.value.cancel = false);

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

.pending-product-grid {
    display: grid;
    grid-template-columns: 0fr 1fr;
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
