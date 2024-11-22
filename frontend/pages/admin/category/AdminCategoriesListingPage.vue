<template>
<div class='w-100'>
    <table class='table table-striped'>
    </table>
</div>
</template>

<script setup lang='ts'>
import { useEventBus } from '@/services/event-bus';

const eventBus = useEventBus();

eventBus.on('create', () => {
    // create new category
});
</script>
