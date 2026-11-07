<script setup lang="ts">
import type { Tool } from '@/types/landing';
import SectionHeading from '@/components/landing/SectionHeading.vue';
import ToolCard from '@/components/landing/ToolCard.vue';

defineProps<{
    tools: Tool[];
}>();
</script>

<template>
    <section class="content-section featured-section">
        <div class="tn-content">
            <div class="section-header-row">
                <SectionHeading
                    eyebrow="Worth a closer look"
                    title="Featured tools"
                    description="A few versatile tools for the moments you need to get something done."
                />
                <span class="featured-caption">Thoughtful tools for everyday work</span>
            </div>
            <div class="featured-grid">
                <ToolCard
                    v-for="tool in tools"
                    :key="tool.title"
                    :tool="tool"
                    :featured="true"
                />
            </div>
        </div>
    </section>
</template>
