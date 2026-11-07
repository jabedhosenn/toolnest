<script setup lang="ts">
import type { Tool } from '@/types/landing';
import SectionHeading from '@/components/landing/SectionHeading.vue';
import ToolCard from '@/components/landing/ToolCard.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

defineProps<{
    tools: Tool[];
}>();
</script>

<template>
    <section class="content-section recently-added-section">
        <div class="tn-content">
            <div class="section-header-row">
                <SectionHeading
                    eyebrow="Fresh from the nest"
                    title="Recently added"
                    description="New additions to help with those little everyday jobs."
                />
                <span class="recently-added-note"><TnIcon name="clock" :size="15" /> Recently published</span>
            </div>
            <div class="tool-grid">
                <ToolCard v-for="tool in tools" :key="tool.title" :tool="tool" />
            </div>
        </div>
    </section>
</template>
