<template>
<div
    class='d-flex flex-wrap justify-content-center'
>
    <router-link
        v-for='table in tables'
        :key='table.id'
        class='btn shadow-sm m-3'
        style='width: 10rem; height: 10rem;'
        :to='{ name: "order", params: { id: table.id } }'
    >
        Tisch {{ table.id }}
        <br>
        <small>Drinks, Zwischensumme, ETC</small>
    </router-link>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Api from '@/services/api';

const tables = ref<Entity.Table[]>([]);

async function fetchTables() {
    tables.value = await Api.get<Entity.Table[]>('/tables');
}

fetchTables();
</script>
