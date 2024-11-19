<template>
<div class='d-flex h-100 overflow-hidden'>
    <admin-sidebar-view />
    <router-view />
</div>
</template>

<script setup lang="ts">
import AdminSidebarView from '@/views/admin/AdminSidebarView.vue';
</script>
