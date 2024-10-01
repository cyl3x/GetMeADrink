<template>
<div
    class='d-flex flex-wrap justify-content-center'
>
</div>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';
import Api from '@/services/api';

const props = defineProps<{
    id: Number,
}>();
</script>
