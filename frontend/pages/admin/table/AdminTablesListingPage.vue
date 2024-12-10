<template>
<div class='w-100 overflow-scroll'>
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
                    Erstellt am
                </th>
                <th class='text-end' scope='col'>
                    Aktionen
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for='table in tables'
                :key='table.id'
            >
                <th scope='row'>
                    {{ table.id }}
                </th>
                <td>{{ table.id }}</td>
                <td>{{ formatDate(table.createdAt) }}</td>
                <td class='text-end'>
                    <button
                        class='btn btn-primary btn-sm btn-danger'
                        @click='deleteTable(table.id)'
                    >
                        Löschen
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script setup lang='ts'>
import { TableService } from '@/services';
import { onMounted, onUnmounted, ref } from 'vue';

const tables = ref<Entity.Table[]>([]);

onMounted(() => { window.addEventListener('admin::create', create); });
onUnmounted(() => { window.removeEventListener('admin::create', create); });

async function create() {
    await TableService.createTable();
    await fetchTables();
}

async function deleteTable(id: number) {
    await TableService.deleteTable(id);
    await fetchTables();
}

async function fetchTables() {
    tables.value = await TableService.getTables();
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('de-DE');
}

fetchTables();
</script>
