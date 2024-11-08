<template>
<div
    class='col overflow-auto'
    style='max-height: 100vh;'
>
    <div class='d-flex flex-wrap justify-content-center'>
        <div class='button-container'>
            <button
                class='btn btn-secondary d-flex justify-content-center flex-column shadow-sm m-3'
                style='width: 10rem; height: 10rem;'
                @click='deselectCategory()'
            >
                <div class='w-100'>
                    <span>Go Back</span>
                </div>
            </button>
        </div>

        <div
            v-for='product in orderStore.selectedCategory?.products'
            :key='product.id'
            class='button-container'
            :class='{ "active": timers.has(product.id) }'
        >
            <button
                class='btn btn-light d-flex justify-content-center flex-column shadow-sm m-3'
                style='width: 10rem; height: 10rem;'
                @click='startOrResetTimer(product.id)'
            >
                <img
                    v-if='product.image'
                    :src='`data:image/png;base64,${product.image}`'
                    class='object-fit-contain'
                    style='height: 100%; width: 100%'
                >

                <div class='w-100'>
                    <span>{{ product.name }} {{ product.variant.name }}</span>
                    <span class='divider-horizontal' />
                    <span>{{ product.price.toFixed(2) }} €</span>
                </div>
            </button>

            <div class='overlay'>
                <button
                    class='side minus no-select rounded-start'
                    style='border-width: 0'
                    @click='removeProductFromPending(product)'
                >
                    -
                </button>
                <div class='d-flex flex-1'>
                    <div class='divider' />
                </div>
                <button
                    class='side plus no-select rounded-end'
                    style='border-width: 0'
                    @click='addProductToPending(product)'
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
import { order } from '@/state';

const orderStore = order.useStore();
const timers = ref<Map<number, number>>(new Map());

function startOrResetTimer(productId: number) {
    if (timers.value.has(productId))
        clearTimeout(timers.value.get(productId));

    const timer = setTimeout(() => {
        timers.value.delete(productId);
    }, 2500);

    timers.value.set(productId, timer);
}

async function addProductToPending(product: Entity.Product) {
    orderStore.addProduct(product);
    startOrResetTimer(product.id);
}

async function removeProductFromPending(product: Entity.Product) {
    orderStore.removeProduct(product);
    startOrResetTimer(product.id);
}

async function deselectCategory() {
    orderStore.selectedCategory = null;
}
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
