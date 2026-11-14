<script setup lang="ts">
import { computed, nextTick, ref } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import CategoriesSection from '@/components/landing/CategoriesSection.vue';
import FeaturedToolsSection from '@/components/landing/FeaturedToolsSection.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import HowItWorksSection from '@/components/landing/HowItWorksSection.vue';
import RecentlyAddedSection from '@/components/landing/RecentlyAddedSection.vue';
import ToolsSection from '@/components/landing/ToolsSection.vue';
import { toolCategories } from '@/data/toolCategories';
import type { Tool } from '@/types/landing';

const popularTools: Tool[] = [
    {
        title: 'Word Counter',
        description: 'Count words, characters, and sentences in a few seconds.',
        category: 'Text Tools',
        icon: 'text',
    },
    {
        title: 'Case Converter',
        description: 'Switch text between sentence, title, upper, and lower case.',
        category: 'Text Tools',
        icon: 'wand',
    },
    {
        title: 'Fancy Text Generator',
        description: 'Give a short message a distinctive style for sharing.',
        category: 'Text Tools',
        icon: 'sparkles',
    },
    {
        title: 'PDF Merger',
        description: 'Bring multiple PDF documents together into one file.',
        category: 'PDF Tools',
        icon: 'files',
    },
    {
        title: 'PDF Compressor',
        description: 'Reduce a PDF’s file size for easier sharing and storage.',
        category: 'PDF Tools',
        icon: 'file',
    },
    {
        title: 'Image Compressor',
        description: 'Make image files smaller while keeping them useful.',
        category: 'Image Tools',
        icon: 'image',
    },
    {
        title: 'Image Converter',
        description: 'Convert images between common file formats.',
        category: 'Image Tools',
        icon: 'image',
    },
    {
        title: 'JSON Formatter',
        description: 'Format and organize JSON so it’s easier to read.',
        category: 'Developer Tools',
        icon: 'code',
    },
];

const featuredTools: Tool[] = [
    {
        title: 'Word Counter',
        description: 'Get a quick count of words, characters, and sentences for your text.',
        category: 'Text Tools',
        icon: 'text',
        label: 'Popular pick',
    },
    {
        title: 'PDF Compressor',
        description: 'Prepare a lighter PDF that’s easier to send and store.',
        category: 'PDF Tools',
        icon: 'file',
        label: 'For your files',
    },
    {
        title: 'Image Converter',
        description: 'Move between common image formats in just a few steps.',
        category: 'Image Tools',
        icon: 'image',
        label: 'For your images',
    },
];

const recentlyAddedTools: Tool[] = [
    {
        title: 'Markdown Preview',
        description: 'Preview Markdown as a clean, readable document.',
        category: 'Developer Tools',
        icon: 'code',
        label: 'New',
    },
    {
        title: 'PDF Splitter',
        description: 'Separate selected pages into smaller PDF files.',
        category: 'PDF Tools',
        icon: 'files',
        label: 'New',
    },
    {
        title: 'SVG to PNG',
        description: 'Convert a vector image into a widely supported PNG.',
        category: 'Image Tools',
        icon: 'image',
        label: 'New',
    },
    {
        title: 'Audio Converter',
        description: 'Convert audio files between common formats.',
        category: 'Audio Tools',
        icon: 'audio',
        label: 'New',
    },
];

const heroRef = ref<InstanceType<typeof HeroSection> | null>(null);
const searchQuery = ref('');
const activeSearchQuery = ref('');

const filteredPopularTools = computed(() => {
    const query = activeSearchQuery.value.toLocaleLowerCase();

    if (!query) {
        return popularTools;
    }

    return popularTools.filter((tool) =>
        [tool.title, tool.description, tool.category]
            .some((value) => value.toLocaleLowerCase().includes(query)),
    );
});

function searchTools(query: string): void {
    searchQuery.value = query;
    activeSearchQuery.value = query;
    document.getElementById('popular-tools')?.scrollIntoView({ behavior: 'smooth' });
}

function focusSearch(): void {
    document.getElementById('top')?.scrollIntoView({ behavior: 'smooth' });
    void nextTick(() => heroRef.value?.focusSearch());
}
</script>

<template>
    <MainLayout @search="focusSearch">
        <HeroSection
            ref="heroRef"
            v-model="searchQuery"
            @search="searchTools"
        />
        <ToolsSection :tools="filteredPopularTools" :search-query="activeSearchQuery" />
        <CategoriesSection :categories="toolCategories" />
        <FeaturedToolsSection :tools="featuredTools" />
        <RecentlyAddedSection :tools="recentlyAddedTools" />
        <HowItWorksSection />
    </MainLayout>
</template>
