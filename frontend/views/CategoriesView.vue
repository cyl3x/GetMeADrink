<template>
<div
    class='col overflow-auto'
    style='max-height: 100vh;'
>
    <div class='d-flex flex-wrap justify-content-center'>
        <div
            v-for='category in categories'
            :key='category.id'
            class='button-container'
        >
            <button
                class='btn btn-light d-flex justify-content-center flex-column shadow-sm m-3'
                style='width: 10rem; height: 10rem;'
                @click='selectCategory(category)'
            >
                <div class='w-100'>
                    <h4>{{ category.name }}</h4>
                    <span>{{ category.products.length }} available</span>
                </div>
            </button>
        </div>
    </div>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { ProductService } from '@/services';
import { order } from '@/state';

const orderStore = order.useStore();
const categories = ref<Entity.ProductCategory[]>([]);

async function fetchCategories() {
    categories.value = await ProductService.getCategories();
}

function selectCategory(category: Entity.ProductCategory) {
    orderStore.selectedCategory = category;
}

fetchCategories();
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
