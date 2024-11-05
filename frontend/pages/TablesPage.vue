<template>
<div
    class='d-flex flex-wrap justify-content-center'
>
    <button
        v-for='table in tables'
        :key='table.id'
        class='btn shadow-sm m-3 position-relative'
        :class='{
            "btn-warning": table.pendingOrder,
            "btn-light": !table.pendingOrder,
        }'
        style='width: 10rem; height: 10rem;'
        :disabled='!!loadingOrder'
        @click='ensureAndNavigateToOrder(table.id)'
    >
        Tisch {{ table.id }}
        <br>

        <span
            v-if='loadingOrder === table.id'
            class='spinner-border'
            role='status'
            aria-hidden='true'
        />

        <span v-else>{{ table.pendingOrder?.totalPrice.toFixed(2) }} €</span>

        <br>
        <small>
            Bestellte Produkte: {{ table.quantityProducts }}
        </small>
    </button>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { OrderService, TableService } from '@/services';
import { order } from '@/state';

const router = useRouter();
const orderStore = order.useStore();
const tables = ref<Entity.Table[]>([]);
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
