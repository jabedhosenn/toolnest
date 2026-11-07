<script setup lang="ts">
import AppHeader from '@/components/AppHeader.vue';

const emit = defineEmits<{
    search: [];
}>();
</script>

<template>
    <div class="app-shell">
        <AppHeader @search="emit('search')" />
        <main>
            <slot />
        </main>
    </div>
</template>
