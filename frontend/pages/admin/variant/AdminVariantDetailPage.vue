<template>
<page-loader-component v-if='variant === undefined || products === undefined' />
<div v-else class='w-100 m-3'>
    <label for='id'>ID</label>
    <input
        id='id'
        disabled
        :value='variant.id ?? "<not saved>"'
        class='form-control'
    >

    <br>

    <label for='name'>Name</label>
    <input
        id='name'
        v-model='variant.name'
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

onMounted(() => { window.addEventListener('admin::save', saveVariant); });
onUnmounted(() => { window.removeEventListener('admin::save', saveVariant); });

const route = useRoute();
const id = computed<number | null>(() => {
    const id = Number(route.params.id);
    return Number.isInteger(id) ? id : null;
});
const variant = ref<DeepPartial<Entity.ProductVariant>>();

async function fetchVariant() {
    if (id.value)
        variant.value = await ProductService.getVariant(Number(route.params.id));
    else
        variant.value = { name: '' };
}

async function saveVariant() {
    if (variant.value !== undefined)
        variant.value = await ProductService.upsertVariant(variant.value);
}

fetchVariant();
</script>
