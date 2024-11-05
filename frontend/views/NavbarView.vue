<template>
<nav class='bg-light shadow-sm p-2'>
    <ol class='breadcrumb m-0'>
        <li
            class='breadcrumb-item'
            :class='{ active: !orderStore.order, pointer: orderStore.order }'
            @click='backToTables'
        >
            GetMeADrink!
        </li>
        <li
            v-if='orderStore.order'
            class='breadcrumb-item'
            :class='{ active: !orderStore.selectedCategory, pointer: !!orderStore.selectedCategory }'
            @click='backToCategories'
        >
            Tisch {{ orderStore.order?.table }}
        </li>
        <li
            v-if='orderStore.selectedCategory'
            class='breadcrumb-item'
            :class='{ active: orderStore.selectedCategory && orderStore.order }'
        >
            {{ orderStore.selectedCategory?.name }}
        </li>
    </ol>
</nav>
</template>

<script setup lang='ts'>
import { order } from '@/state';
import { useRouter } from 'vue-router';

const orderStore = order.useStore();
const router = useRouter();

function backToTables() {
    orderStore.order = null;
    orderStore.selectedCategory = null;
    router.push({ name: 'tables' });
}

function backToCategories() {
    orderStore.selectedCategory = null;
}
</script>

<style>
.pointer {
    cursor: pointer;
}
</style>
