<template>
<table class='table table-striped'>
    <thead>
        <tr>
            <th scope='col'>
                #
            </th>
            <th scope='col'>
                Tisch
            </th>
            <th scope='col'>
                Status
            </th>
            <th scope='col'>
                Preis
            </th>
            <th scope='col'>
                Produkte
            </th>
            <th scope='col'>
                Erstellt am
            </th>
        </tr>
    </thead>
    <tbody>
        <tr
            v-for='order in orders'
            :key='order.id'
        >
            <th scope='row'>{{ order.id }}</th>
            <td>{{ order.table }}</td>
            <td>
                <span
                    class='badge rounded-pill'
                    :class='statusClass(order.status)'
                >
                    {{ statusText(order.status) }}
                </span>
            </td>
            <td>{{ order.totalPrice.toFixed(2) }} €</td>
            <td>{{ order.orderProducts.length }}</td>
            <td>{{ formatDate(order.createdAt) }}</td>
        </tr>
    </tbody>
    <tfoot>
        <!-- Pagination -->
    </tfoot>
</table>
</template>

<script setup lang='ts'>
import { OrderService } from '@/services';
import { ref } from 'vue';


const orders = ref<Entity.Order[]>([]);

async function fetchOrders() {
    orders.value = await OrderService.getOrtders();
}

function statusClass(status: Entity.Order['status']) {
    switch (status) {
        case 'canceled': return 'text-bg-danger';
        case 'pending': return 'text-bg-warning';
        case 'completed': return 'text-bg-success';
        default: return '';
    }
}

function statusText(status: Entity.Order['status']) {
    switch (status) {
        case 'canceled': return 'Storniert';
        case 'pending': return 'Ausstehend';
        case 'completed': return 'Abgeschlossen';
        default: return '';
    }
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('de-DE');
}

fetchOrders();
</script>
