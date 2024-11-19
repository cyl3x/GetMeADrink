<template>
<div class='card-grid-container'>
    <div class='card-grid'>
        <button
            v-for='category in Object.values(categoriesStore.categories ?? {})'
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
import { useRouter } from 'vue-router';
import { categories } from '@/state';

const categoriesStore = categories.useStore();
const router = useRouter();

function selectCategory(category: Entity.ProductCategory) {
    router.push({ name: 'order.products', params: { categoryId: category.id } });
}
</script>
