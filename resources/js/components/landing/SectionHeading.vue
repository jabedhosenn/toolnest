<script setup lang="ts">
defineProps<{
    eyebrow?: string;
    title: string;
    description?: string;
    align?: 'left' | 'center';
}>();
</script>

<template>
    <div class="section-heading" :class="{ 'section-heading-centered': align === 'center' }">
        <p v-if="eyebrow" class="section-eyebrow">{{ eyebrow }}</p>
        <h2>{{ title }}</h2>
        <p v-if="description" class="section-description">{{ description }}</p>
        <slot />
    </div>
</template>
