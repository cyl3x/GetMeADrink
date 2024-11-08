<template>
<div class='toast-container position-fixed top-0 end-0 p-3'>
    <TransitionGroup name='fade'>
        <div
            v-for='[id, toast] in notificationStore.notifications.entries()'
            :key='id'
            class='toast d-block'
            role='alert'
            aria-live='assertive'
            aria-atomic='true'
        >
            <div class='toast-header'>
                <div class='rounded me-2 bg-danger' style='height: 15px; width: 15px;' />
                <strong class='me-auto'>{{ toast.title }}</strong>
                <button
                    type='button'
                    class='btn-close'
                    aria-label='Close'
                    @click='notificationStore.dismiss(id)'
                />
            </div>
            <div class='toast-body'>
                {{ toast.message }}
            </div>
        </div>
    </TransitionGroup>
</div>
</template>

<script setup lang="ts">
import { notification } from '@/state';

const notificationStore = notification.useStore();

</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
