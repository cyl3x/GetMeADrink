<template>
<nav class='bg-light shadow-sm p-2 z-2 d-flex justify-content-between align-items-center'>
    <ol class='breadcrumb m-0 fs-5'>
        <li
            class='breadcrumb-item pointer d-flex align-items-center gap-1 logo'
            :class='{ "text-danger": isAdmin, active: is("tables") }'
            @click='router.push({ name: "tables" })'
        >
            <template v-if='!is("tables")'>
                &#8592;
            </template>

            <img src='/public/favicon/icon.svg'>

            GetMeADrink
        </li>
        <template v-if='isAdmin'>
            <li
                v-if='startWith("admin.order")'
                class='breadcrumb-item pointer'
                :class='{ active: is("admin.products") }'
                @click='router.push({ name: "admin.orders" })'
            >
                Bestellungen
            </li>
            <li
                v-if='startWith("admin.product")'
                class='breadcrumb-item pointer'
                :class='{ active: is("admin.products") }'
                @click='router.push({ name: "admin.products" })'
            >
                Produkte
            </li>
            <li
                v-if='startWith("admin.categor")'
                class='breadcrumb-item pointer'
                :class='{ active: is("admin.categories") }'
                @click='router.push({ name: "admin.categories" })'
            >
                Kategorien
            </li>
            <li
                v-if='startWith("admin.variant")'
                class='breadcrumb-item pointer'
                :class='{ active: is("admin.variants") }'
                @click='router.push({ name: "admin.variants" })'
            >
                Varianten
            </li>
            <li
                v-if='startWith("admin.table")'
                class='breadcrumb-item pointer'
                :class='{ active: is("admin.tables") }'
                @click='router.push({ name: "admin.tables" })'
            >
                Tische
            </li>
            <li
                v-if='is("admin.table") || is("admin.category") || is("admin.product")'
                class='breadcrumb-item pointer active'
            >
                {{ route.params?.id }}
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
import { computed, watch } from 'vue';
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
    return is('admin.table') || is('admin.category');
});

function is(name: string): boolean {
    return route.name === name;
}

function startWith(name: string): boolean {
    return route.name?.toString().startsWith(name) ?? false;
}

function emitEvent(name: string) {
    window.dispatchEvent(new CustomEvent(`admin::${name}`));
}

watch(() => route.name, () => {
    document.title = 'GetMeADrink';

    if (is('tables')) {
        document.title += ' | Tische';
    } else if (isOrder.value) {
        document.title += ` | Tisch ${orderStore.order?.table}`;

        if (is('order.products'))
            document.title += ` | ${categoriesStore.getCategory(route)?.name}`;
    } else if (isAdmin.value) {
        document.title += ' Admin';

        if (is('admin.orders'))
            document.title += ' | Bestellungen';
        else if (is('admin.products'))
            document.title += ' | Produkte';
        else if (is('admin.categories'))
            document.title += ' | Kategorien';
        else if (is('admin.tables'))
            document.title += ' | Tische';
        else if (is('admin.variants'))
            document.title += ' | Varianten';
        else if (is('admin.product'))
            document.title += route.params?.id ? ` | Produkt ${route.params?.id}` : ' | Neues Produkt';
        else if (is('admin.category'))
            document.title += route.params?.id ? ` | Kategorie ${route.params?.id}` : ' | Neue Kategorie';
        else if (is('admin.variant'))
            document.title += route.params?.id ? ` | Variante ${route.params?.id}` : ' | Neue Variante';
    }
});
</script>

<style>
.pointer {
    cursor: pointer;
}

.logo img {
    width: 28px;
    height: auto;
    filter: invert(1) brightness(20%);
}

.logo.active img {
    filter: invert(1) brightness(40%);
}

.logo.text-danger img {
    filter: invert(29%) sepia(36%) saturate(4216%) hue-rotate(334deg) brightness(90%) contrast(91%);
}
</style>
