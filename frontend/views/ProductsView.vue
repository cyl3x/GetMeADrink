<template>
<div
    class='col overflow-auto'
    style='max-height: 100vh;'
>
    <div class='d-flex flex-wrap justify-content-center'>
        <div
            v-for='product in products'
            :key='product.id'
            class='button-container'
            :class='{ "active": timers.has(product.id) }'
        >
            <button
                class='btn btn-light shadow-sm m-3'
                style='width: 10rem; height: 10rem; max-width: 10rem; max-height: 10rem;'
                @click='startOrResetTimer(product.id)'
            >
                <span class='w-100 h-100'>
                    <img
                        v-if='product.image'
                        :src='`data:image/png;base64,${product.image}`'
                        class='w-100 h-100'
                    >
                </span>

                <span>{{ product.name }} {{ product.variant.name }}</span>
                <span class='divider-horizontal' />
                <span>{{ product.price.toFixed(2) }} €</span>
            </button>

            <div class='overlay'>
                <button
                    class='side minus no-select rounded-start'
                    style='border-width: 0'
                    @click='removeProduct(product.id)'
                >
                    -
                </button>
                <div class='d-flex flex-1'>
                    <div class='divider' />
                </div>
                <button
                    class='side plus no-select rounded-end'
                    style='border-width: 0'
                    @click='addProduct(product.id)'
                >
                    +
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { OrderService, ProductService } from '@/services';
import { order } from '@/state';

const orderStore = order.useStore();
const products = ref<Entity.Product[]>([]);
const timers = ref<Map<number, number>>(new Map());

function startOrResetTimer(productId: number) {
    if (timers.value.has(productId))
        clearTimeout(timers.value.get(productId));

    const timer = setTimeout(() => {
        timers.value.delete(productId);
    }, 2500);

    timers.value.set(productId, timer);
}

async function fetchProducts() {
    products.value = await ProductService.getProducts();
}

async function addProduct(productId: number) {
    if (!orderStore.order)
        throw new Error('No order available');

    startOrResetTimer(productId);

    const order = await OrderService.addProduct(orderStore.order?.id, productId);

    orderStore.order = order;
}

async function removeProduct(productId: number) {
    if (!orderStore.order)
        throw new Error('No order available');

    startOrResetTimer(productId);

    const order = await OrderService.removeProduct(orderStore.order?.id, productId);

    orderStore.order = order;
}

fetchProducts();
</script>

<style>
.button-container {
    position: relative;
    display: inline-block;
}

.overlay {
    position: absolute;
    top: 0;
    right: 1rem;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.button-container.active .overlay {
    opacity: 1;
    pointer-events: auto;
}

.overlay .side {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 3rem;
    font-weight: bold;
    cursor: pointer;
}

.overlay .minus {
    color: black;
    background-color: rgba(255, 0, 0, 0.25);
    display: flex;
    flex:1;
    height: 10rem;
    width: 5rem;
    line-height: 10rem;
    font-family: monospace;
}

.overlay .plus {
    color: black;
    background-color: rgba(0, 255, 0, 0.25);
    display: flex;
    flex:1;
    height: 10rem;
    width: 5rem;
    line-height:10rem;
    font-family: monospace
}

.divider {
    width: 2px;
    height: 10rem;
    background-color: black;
    display:flex;
    flex:auto
}

.divider-horizontal {
    width: 100%;
    height: 2px;
    background-color: black;
    display:flex;
    flex-direction: row;
    flex:auto;
}

.no-select {
    user-select: none
}
</style>
