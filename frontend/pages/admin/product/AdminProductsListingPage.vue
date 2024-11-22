<template>
<div class='w-100'>
    <table class='table table-striped'>
    </table>
</div>
</template>

<script setup lang='ts'>
import { onMounted, onUnmounted } from 'vue';

onMounted(() => { window.addEventListener('admin::create', create); });
onUnmounted(() => { window.removeEventListener('admin::create', create); });

function create() {
    console.log('create new product');
}
</script>
