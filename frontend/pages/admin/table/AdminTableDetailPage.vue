<template>
<page-loader-component v-if='table === undefined' />
<div v-else class='w-100 m-3'>
    <label for='tableId'>Tisch</label>
    <input
        id='tableId'
        :value='table.id'
        class='form-control'
        @input='table.id = Number($event)'
    >
</div>
</template>

<script setup lang='ts'>
import PageLoaderComponent from '@/components/PageLoaderComponent.vue';
import { TableService } from '@/services';
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const id = computed<number | null>(() => {
    const id = Number(route.params.id);
    return Number.isInteger(id) ? id : null;
});
const table = ref<Partial<Entity.Table>>();

async function fetchTable() {
    if (id.value)
        table.value = await TableService.getTable(Number(route.params.id));
    else
        table.value = {};
}

fetchTable();
</script>
