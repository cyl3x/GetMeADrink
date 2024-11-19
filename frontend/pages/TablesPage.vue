<template>
<page-loader-component v-if='tables === undefined'>
    Lade Tische...
</page-loader-component>

<div
    v-else
    class='card-grid'
>
    <button
        v-for='table in tables'
        :key='table.id'
        class='card-grid-item btn shadow-sm'
        :class='{
            "btn-warning": table.pendingOrder,
            "btn-light": !table.pendingOrder,
        }'
        style='width: 10rem; height: 10rem;'
        :disabled='!!loadingOrder'
        @click='ensureAndNavigateToOrder(table.id)'
    >
        <div v-if='!loadingOrder'>
            Tisch {{ table.id }}
            <br v-if='table.pendingOrder'>
        </div>
        <span
            v-if='loadingOrder === table.id'
            class='spinner-border'
            role='status'
            aria-hidden='true'
        />
        <span v-else>{{ table.pendingOrder?.totalPrice.toFixed(2) }} {{ table.pendingOrder ? "€" : "" }}</span>
        <div v-if='!loadingOrder'>
            <small>
                {{ table.pendingOrder ? "Bestellte Produkte: " + table.quantityProducts : "" }}
            </small>
        </div>
    </button>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { OrderService, TableService } from '@/services';
import { order } from '@/state';
import PageLoaderComponent from '@/components/PageLoaderComponent.vue';

const router = useRouter();
const orderStore = order.useStore();
const tables = ref<Entity.Table[]>();
const loadingOrder = ref<number>();

async function fetchTables() {
    tables.value = await TableService.getTables();
}

async function ensureAndNavigateToOrder(tableId: number) {
    loadingOrder.value = tableId;

    const order = await OrderService.ensureOrder(tableId);

    orderStore.order = order;

    loadingOrder.value = undefined;

    router.push({ name: 'order', params: { id: order.id } });
}

fetchTables();
</script>
