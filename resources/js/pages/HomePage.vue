<script setup lang="ts">
import { computed, nextTick, onMounted, ref } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import CategoriesSection from '@/components/landing/CategoriesSection.vue';
import FeaturedToolsSection from '@/components/landing/FeaturedToolsSection.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import HowItWorksSection from '@/components/landing/HowItWorksSection.vue';
import RecentlyAddedSection from '@/components/landing/RecentlyAddedSection.vue';
import ToolsSection from '@/components/landing/ToolsSection.vue';
import { useToolDirectoryStore } from '@/stores/toolDirectory';
import type { Tool } from '@/types/landing';

const directory = useToolDirectoryStore();
const heroRef = ref<InstanceType<typeof HeroSection> | null>(null);
const searchQuery = ref('');
const activeSearchQuery = ref('');
const visibleTools = ref<Tool[]>([]);
const isLoading = ref(true);
const isSearching = ref(false);
const directoryError = ref<string | null>(null);
const searchError = ref<string | null>(null);

const heroSuggestions = computed(() => directory.popularTools.slice(0, 4).map((tool) => tool.title));

onMounted(async () => {
    try {
        await directory.loadLandingDirectory();
        visibleTools.value = directory.popularTools;
    } catch (error) {
        directoryError.value = error instanceof Error ? error.message : String(error);
    } finally {
        isLoading.value = false;
    }
});

async function searchTools(query: string): Promise<void> {
    searchQuery.value = query;
    activeSearchQuery.value = query;

    if (!query) {
        visibleTools.value = directory.popularTools;
        searchError.value = null;
        return;
    }

    isSearching.value = true;
    searchError.value = null;

    try {
        visibleTools.value = await directory.searchTools(query);
    } catch (error) {
        searchError.value = error instanceof Error ? error.message : String(error);
    } finally {
        isSearching.value = false;
    }

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
            :suggestions="heroSuggestions"
            @search="searchTools"
        />
        <p v-if="directoryError" class="directory-error" role="alert">
            Tool directory could not be loaded: {{ directoryError }}
        </p>
        <p v-else-if="isLoading" class="directory-status" role="status">Loading tools…</p>
        <p v-if="searchError" class="directory-error" role="alert">
            Tool search failed: {{ searchError }}
        </p>
        <p v-else-if="isSearching" class="directory-status" role="status">Searching tools…</p>
        <ToolsSection :tools="visibleTools" :search-query="activeSearchQuery" />
        <CategoriesSection :categories="directory.categories" />
        <FeaturedToolsSection :tools="directory.featuredTools" />
        <RecentlyAddedSection :tools="directory.recentTools" />
        <HowItWorksSection />
    </MainLayout>
</template>
