<template>
<div class='w-100'>
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
                <th scope='col'>
                    Aktionen
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for='table in tables'
                :key='table.id'
            >
                <th scope='row'>{{ table.id }}</th>
                <td>{{ table.id }}</td>
                <td>{{ formatDate(table.createdAt) }}</td>
                <td>
                    <button
                        class='btn btn-primary btn-sm'
                        @click='edit(table.id)'
                    >
                        Bearbeiten
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
import { useRouter } from 'vue-router';

const tables = ref<Entity.Table[]>([]);
const router = useRouter();

onMounted(() => { window.addEventListener('admin::create', create); });
onUnmounted(() => { window.removeEventListener('admin::create', create); });

function create() {
    router.push({ name: 'admin.table' });
}

function edit(id: number) {
    router.push({ name: 'admin.table', params: { id } });
}

async function fetchTables() {
    tables.value = await TableService.getTables();
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('de-DE');
}

fetchTables();
</script>
