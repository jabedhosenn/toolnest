<script setup lang="ts">
import type { Tool } from '@/types/landing';
import TnIcon from '@/components/ui/TnIcon.vue';

withDefaults(
    defineProps<{
        tool: Tool;
        featured?: boolean;
    }>(),
    {
        featured: false,
    },
);
</script>

<template>
    <a
        class="tool-card"
        :class="{ 'tool-card-featured': featured }"
        :href="tool.href ?? '#hero-search'"
    >
        <div class="tool-card-top">
            <span class="tool-icon"><TnIcon :name="tool.icon" :size="21" /></span>
            <span v-if="tool.label" class="tool-label">{{ tool.label }}</span>
            <span v-else class="tool-arrow" aria-hidden="true">
                <TnIcon name="arrow-up-right" :size="17" />
            </span>
        </div>
        <div class="tool-card-copy">
            <span class="tool-category">{{ tool.category }}</span>
            <h3>{{ tool.title }}</h3>
            <p>{{ tool.description }}</p>
        </div>
        <span class="tool-card-link">
            Explore tool
            <TnIcon name="arrow-right" :size="15" />
        </span>
    </a>
</template>
