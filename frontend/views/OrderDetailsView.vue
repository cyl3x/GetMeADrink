<template>
<div
    class='fixed-left overflow-y-scroll p-3 bg-light shadow d-flex flex-column gap-4'
    style='min-width: 300px;'
>
    <div>
        <button
            :disabled='loading'
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
        <div class='pending-product-grid'>
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
                    {{ product.name }}
                </div>
                <div>{{ (product.price * product.quantity).toFixed(2) }} €</div>
            </template>
        </div>
    </div>

    <div v-if='orderStore.order' class='d-flex flex-column gap-3'>
        <button
            v-if='orderStore.order?.totalPrice!=0'
            :disabled='loading'
            class='btn btn-success'
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
                {{ orderStore.order.totalPrice.toFixed(2) }}
            </template>
            €
        </button>
        <button
            :disabled='loading'
            class='btn btn-secondary'
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

function navigateToTables() {
    router.push({ name: 'tables' });
    orderStore.order = null;
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
