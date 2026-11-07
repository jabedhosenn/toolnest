<script setup lang="ts">
import type { Tool } from '@/types/landing';
import SectionHeading from '@/components/landing/SectionHeading.vue';
import ToolCard from '@/components/landing/ToolCard.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

defineProps<{
    tools: Tool[];
    searchQuery: string;
}>();
</script>

<template>
    <section id="popular-tools" class="content-section">
        <div class="tn-content">
            <div class="section-header-row">
                <SectionHeading
                    eyebrow="Your toolkit"
                    title="Popular tools"
                    description="A few handy places to start, for words, files, images, and more."
                />
                <a class="text-link section-header-link" href="#categories">
                    Browse categories
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <p v-if="searchQuery" class="search-results-label" aria-live="polite">
                Results for <strong>“{{ searchQuery }}”</strong>
            </p>
            <div v-if="tools.length" class="tool-grid">
                <ToolCard v-for="tool in tools" :key="tool.title" :tool="tool" />
            </div>
            <div v-else class="empty-search">
                <span class="tool-icon"><TnIcon name="search" /></span>
                <h3>No matching tools yet</h3>
                <p>Try a different search, or browse all categories to explore what’s available.</p>
                <a class="text-link" href="#categories">Explore categories <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>
</template>
