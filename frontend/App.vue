<template>
<navbar-view />
<router-view />
<notification-view />
</template>

<script setup lang="ts">
import NavbarView from '@/views/NavbarView.vue';
import NotificationView from '@/views/NotificationView.vue';
</script>
