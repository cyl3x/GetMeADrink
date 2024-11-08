<template>
<page-loader-view v-if='categories === undefined'>
    Lade Produkte...
</page-loader-view>

<div v-else class='card-grid-container'>
    <div class='card-grid'>
        <button
            v-for='category in categories'
            :key='category.id'
            class='card-grid-item card-grid-item__content btn btn-light shadow-sm'
            @click='selectCategory(category)'
        >
            <h4>{{ category.name }}</h4>
        </button>
    </div>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { ProductService } from '@/services';
import { order } from '@/state';
import PageLoaderView from '../components/PageLoaderComponent.vue';

const orderStore = order.useStore();
const categories = ref<Entity.ProductCategory[]>();

async function fetchCategories() {
    categories.value = await ProductService.getCategories();
}

function selectCategory(category: Entity.ProductCategory) {
    orderStore.selectedCategory = category;
}

fetchCategories();
</script>
