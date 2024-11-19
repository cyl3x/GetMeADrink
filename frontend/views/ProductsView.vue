<template>
<div class='card-grid-container'>
    <div class='card-grid'>
        <button
            class='card-grid-item btn btn-secondary shadow-sm'
            @click='deselectCategory()'
        >
            <div class='w-100'>
                <span>Go Back</span>
            </div>
        </button>

        <button
            v-for='product in categoriesStore.getCategory($route)?.products'
            :key='product.id'
            class='card-grid-item btn btn-light shadow-sm'
            :class='{ "active": timers.has(product.id) }'
            @click='startOrResetTimer(product.id)'
        >
            <div class='card-grid-item__content'>
                <img
                    v-if='product.image'
                    :src='product.image'
                    class='card-grid-item__image mb-2'
                >

                <span>{{ product.name }}</span>
                <span>{{ product.variant.name }} | {{ product.price.toFixed(2) }} €</span>
            </div>

            <div class='card-grid-item__overlay'>
                <button
                    class='minus'
                    @click='removeProductFromPending(product)'
                >
                    -
                </button>

                <div class='border border-black h-100' />

                <button
                    class='plus'
                    @click='addProductToPending(product)'
                >
                    +
                </button>
            </div>
        </button>
    </div>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { categories, order } from '@/state';
import { useRouter } from 'vue-router';

const categoriesStore = categories.useStore();
const orderStore = order.useStore();
const router = useRouter();
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
    router.push({ name: 'order.categories' });
}
</script>

<style>
.card-grid-item__overlay button {
    width: 100%;
    height: 100%;
    text-align: center;
    font-size: 3rem;
    font-weight: bold;
    user-select: none;
    font-family: monospace;
    color: black;
    border: none;
}

.card-grid-item__overlay .minus {
    background-color: rgba(255, 0, 0, 0.25);
}

.card-grid-item__overlay .plus {
    background-color: rgba(0, 255, 0, 0.25);
}
</style>
