<template>
<navbar-component />
<router-view />
<notification-component />
</template>

<script setup lang="ts">
import NavbarComponent from '@/components/NavbarComponent.vue';
import NotificationComponent from '@/components/NotificationComponent.vue';
</script>
