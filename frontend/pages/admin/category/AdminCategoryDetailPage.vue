<template>
<page-loader-component v-if='category === undefined' />
<div v-else class='w-100 m-3'>
    <label for='id'>ID</label>
    <input
        id='id'
        disabled
        :value='category.id ?? "<not saved>"'
        class='form-control'
    >
    <label for='name'>Name</label>
    <input
        id='name'
        v-model='category.name'
        type='text'
        class='form-control'
    >
    <!-- @TODO - Multi product select -->
</div>
</template>

<script setup lang='ts'>
import PageLoaderComponent from '@/components/PageLoaderComponent.vue';
import { ProductService } from '@/services';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { useRoute } from 'vue-router';

onMounted(() => { window.addEventListener('admin::save', saveCategory); });
onUnmounted(() => { window.removeEventListener('admin::save', saveCategory); });

const route = useRoute();
const id = computed<number | null>(() => {
    const id = Number(route.params.id);
    return Number.isInteger(id) ? id : null;
});
const category = ref<DeepPartial<Entity.ProductCategory>>();

async function fetchCategory() {
    if (id.value)
        category.value = await ProductService.getCategory(Number(route.params.id));
    else
        category.value = { name: '' };
}

async function saveCategory() {
    if (category.value !== undefined)
        category.value = await ProductService.upsertCategory(category.value);
}

fetchCategory();
</script>
