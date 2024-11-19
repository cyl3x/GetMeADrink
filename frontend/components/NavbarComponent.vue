<template>
<nav class='bg-light shadow-sm p-2 z-1 fs-5'>
    <ol class='breadcrumb m-0'>
        <li
            class='breadcrumb-item'
            :class='{ active: isTables, pointer: !isTables }'
            @click='backToTables'
        >
            <template v-if='!isTables'>
                &#8592;
            </template>
            GetMeADrink
        </li>
        <li
            v-if='isOrder'
            class='breadcrumb-item'
            :class='{ active: isCategories, pointer: isProducts }'
            @click='backToCategories'
        >
            Tisch {{ orderStore.order?.table }}
        </li>
        <li
            v-if='isProducts'
            class='breadcrumb-item active'
        >
            {{ categoriesStore.getCategory($route)?.name }}
        </li>
    </ol>
</nav>
</template>

<script setup lang='ts'>
import { categories, order } from '@/state';
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const orderStore = order.useStore();
const categoriesStore = categories.useStore();
const router = useRouter();
const route = useRoute();

const isTables = computed(() => {
    return route.name === 'tables';
});


const isOrder = computed(() => {
    return route.name?.toString().startsWith('order') || false;
});

const isCategories = computed(() => {
    return route.name === 'order.categories';
});

const isProducts = computed(() => {
    return route.name === 'order.products';
});

function backToTables() {
    if (route.name !== 'tables') {
        orderStore.order = null;
        router.push({ name: 'tables' });
    }
}

function backToCategories() {
    if (route.name !== 'order.categories')
        router.push({ name: 'order.categories' });
}
</script>

<style>
.pointer {
    cursor: pointer;
}
</style>
