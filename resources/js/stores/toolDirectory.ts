import { defineStore } from 'pinia';
import { ref } from 'vue';
import {
    fetchFeaturedTools,
    fetchPopularTools,
    fetchRecentTools,
    fetchToolCategories,
    searchTools,
} from '@/services/tools';
import type { Tool, ToolCategory } from '@/types/landing';

export const useToolDirectoryStore = defineStore('toolDirectory', () => {
    const categories = ref<ToolCategory[]>([]);
    const popularTools = ref<Tool[]>([]);
    const featuredTools = ref<Tool[]>([]);
    const recentTools = ref<Tool[]>([]);

    async function loadLandingDirectory(): Promise<void> {
        const [loadedCategories, loadedPopularTools, loadedFeaturedTools, loadedRecentTools] = await Promise.all([
            fetchToolCategories(),
            fetchPopularTools(),
            fetchFeaturedTools(),
            fetchRecentTools(),
        ]);

        categories.value = loadedCategories;
        popularTools.value = loadedPopularTools;
        featuredTools.value = loadedFeaturedTools;
        recentTools.value = loadedRecentTools;
    }

    return {
        categories,
        popularTools,
        featuredTools,
        recentTools,
        loadLandingDirectory,
        searchTools,
    };
});
