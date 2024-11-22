<template>
<nav class='bg-light shadow-sm p-2 z-2 d-flex justify-content-between align-items-center'>
    <ol class='breadcrumb m-0 fs-5'>
        <li
            class='breadcrumb-item pointer'
            :class='{ "text-danger": isAdmin, active: is("tables") }'
            @click='router.push({ name: "tables" })'
        >
            <template v-if='!is("tables")'>
                &#8592;
            </template>
            GetMeADrink
        </li>
        <template v-if='isAdmin'>
            <li
                v-if='is("admin.orders")'
                class='breadcrumb-item pointer active'
                @click='router.push({ name: "admin.orders" })'
            >
                Bestellungen
            </li>
            <li
                v-if='is("admin.products")'
                class='breadcrumb-item pointer active'
                @click='router.push({ name: "admin.products" })'
            >
                Produkte
            </li>
            <li
                v-if='is("admin.categories")'
                class='breadcrumb-item pointer active'
                @click='router.push({ name: "admin.categories" })'
            >
                Kategorien
            </li>
            <li
                v-if='is("admin.tables")'
                class='breadcrumb-item pointer active'
                @click='router.push({ name: "admin.tables" })'
            >
                Tische
            </li>
        </template>
        <template v-else-if='isOrder'>
            <li
                class='breadcrumb-item pointer'
                :class='{ active: is("order.categories") }'
                @click='router.push({ name: "order.categories" })'
            >
                Tisch {{ orderStore.order?.table }}
            </li>
            <li
                v-if='is("order.products")'
                class='breadcrumb-item pointer'
                :class='{ active: is("order.products") }'
            >
                {{ categoriesStore.getCategory($route)?.name }}
            </li>
        </template>
    </ol>

    <router-link v-if='is("tables")' :to='{ name: "admin" }'>
        Admin &#8594;
    </router-link>

    <button
        v-if='isListing'
        class='btn btn-primary btn-sm'
        @click='emitEvent("create")'
    >
        Erstellen
    </button>

    <button
        v-if='isDetail'
        class='btn btn-primary btn-sm'
        @click='emitEvent("save")'
    >
        Speichern
    </button>
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

const isAdmin = computed(() => {
    return route.name?.toString().startsWith('admin') || false;
});

const isOrder = computed(() => {
    return route.name?.toString().startsWith('order') || false;
});

const isListing = computed(() => {
    return is('admin.products') || is('admin.categories') || is('admin.tables');
});

const isDetail = computed(() => {
    return is('admin.table') || is('admin.category') || is('admin.table');
});

function is(name: string): boolean {
    return route.name === name;
}

function emitEvent(name: string) {
    window.dispatchEvent(new CustomEvent(`admin::${name}`));
}
</script>

<style>
.pointer {
    cursor: pointer;
}
</style>
