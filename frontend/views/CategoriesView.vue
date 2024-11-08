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
</style>
