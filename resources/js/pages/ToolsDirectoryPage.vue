<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { RouterLink } from 'vue-router';
import MainLayout from '@/layouts/MainLayout.vue';
import ToolCard from '@/components/landing/ToolCard.vue';
import TnEmptyState from '@/components/ui/TnEmptyState.vue';
import TnIcon from '@/components/ui/TnIcon.vue';
import TnPagination from '@/components/ui/TnPagination.vue';
import ToolDirectorySearch from '@/components/ToolDirectorySearch.vue';
import { fetchToolCategories, fetchTools } from '@/services/tools';
import type { ToolListFilters } from '@/types/api';
import type { PaginationMeta } from '@/types/design-system';
import type { Tool, ToolCategory } from '@/types/landing';

const props = defineProps<{
    categorySlug?: string;
}>();

const categories = ref<ToolCategory[]>([]);
const tools = ref<Tool[]>([]);
const searchQuery = ref('');
const loadedSearchQuery = ref('');
const selectedCategory = ref('');
const sortOrder = ref<ToolListFilters['sort']>('sort_order');
const currentPage = ref(1);
const totalTools = ref(0);
const lastPage = ref(1);
const isLoading = ref(true);
const isReady = ref(false);
const directoryError = ref<string | null>(null);
const toolsError = ref<string | null>(null);
let debounceTimer: ReturnType<typeof setTimeout> | undefined;
let requestSequence = 0;

const isCategoryPage = computed(() => Boolean(props.categorySlug));
const currentCategory = computed(() => categories.value.find((category) => category.slug === props.categorySlug));
const relatedCategories = computed(() => categories.value.filter((category) => category.slug !== props.categorySlug));
const suggestions = computed(() => loadedSearchQuery.value === searchQuery.value.trim()
    ? tools.value.slice(0, 5).map((tool) => tool.title)
    : []);
const pagination = computed<PaginationMeta>(() => ({
    currentPage: currentPage.value,
    lastPage: lastPage.value,
    perPage: 12,
    total: totalTools.value,
}));

function scheduleLoad(): void {
    if (!isReady.value) {
        return;
    }

    requestSequence++;
    isLoading.value = true;

    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(() => {
        void loadTools();
    }, 300);
}

async function loadTools(): Promise<void> {
    const sequence = ++requestSequence;
    isLoading.value = true;
    toolsError.value = null;

    const filters: ToolListFilters = {
        category: props.categorySlug || selectedCategory.value || undefined,
        q: searchQuery.value.trim() || undefined,
        sort: sortOrder.value,
        page: currentPage.value,
        per_page: 12,
    };

    try {
        const response = await fetchTools(filters);

        if (sequence !== requestSequence) {
            return;
        }

        tools.value = response.data;
        loadedSearchQuery.value = filters.q ?? '';
        totalTools.value = response.meta.total;
        lastPage.value = response.meta.last_page;
    } catch (error) {
        if (sequence === requestSequence) {
            toolsError.value = error instanceof Error ? error.message : String(error);
            tools.value = [];
            totalTools.value = 0;
            lastPage.value = 1;
        }
    } finally {
        if (sequence === requestSequence) {
            isLoading.value = false;
        }
    }
}

function changePage(page: number): void {
    currentPage.value = page;
}

function focusSearch(): void {
    document.querySelector<HTMLInputElement>('.directory-search input')?.focus();
}

watch([searchQuery, selectedCategory, sortOrder], () => {
    currentPage.value = 1;
    scheduleLoad();
});

watch(currentPage, scheduleLoad);

watch(
    () => props.categorySlug,
    () => {
        currentPage.value = 1;
        searchQuery.value = '';
        scheduleLoad();
    },
);

onMounted(async () => {
    try {
        categories.value = await fetchToolCategories();
        isReady.value = true;
        await loadTools();
    } catch (error) {
        directoryError.value = error instanceof Error ? error.message : String(error);
        isLoading.value = false;
    }
});

onBeforeUnmount(() => {
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }
    requestSequence++;
});
</script>

<template>
    <MainLayout @search="focusSearch">
        <section class="content-section directory-page">
            <div class="tn-content">
                <div v-if="isCategoryPage && currentCategory" class="directory-category-heading">
                    <span class="directory-category-icon">
                        <TnIcon :name="currentCategory.icon" :size="27" />
                    </span>
                    <div class="section-heading">
                        <p class="section-eyebrow">Tool category</p>
                        <h1>{{ currentCategory.title }}</h1>
                        <p class="section-description">{{ currentCategory.description }}</p>
                    </div>
                </div>
                <div v-else-if="!isCategoryPage" class="section-heading">
                    <p class="section-eyebrow">Explore the directory</p>
                    <h1>All tools</h1>
                    <p class="section-description">
                        Find the right tool for your next task. Search across names, descriptions, and tags, or browse by category.
                    </p>
                </div>

                <p v-if="directoryError" class="directory-message directory-error" role="alert">
                    Categories could not be loaded: {{ directoryError }}
                </p>
                <p v-else-if="isCategoryPage && !currentCategory && !isLoading" class="directory-message directory-error" role="alert">
                    This category could not be found.
                </p>

                <div v-if="!isCategoryPage || currentCategory" class="directory-controls">
                    <ToolDirectorySearch
                        v-model="searchQuery"
                        :suggestions="suggestions"
                        :loading="isLoading && Boolean(searchQuery.trim())"
                        :placeholder="isCategoryPage ? `Search ${currentCategory?.title ?? 'this category'}` : undefined"
                    />

                    <div v-if="!isCategoryPage" class="directory-filters">
                        <label class="directory-filter">
                            <span>Category</span>
                            <select v-model="selectedCategory" aria-label="Filter by category">
                                <option value="">All categories</option>
                                <option v-for="category in categories" :key="category.slug" :value="category.slug">
                                    {{ category.title }}
                                </option>
                            </select>
                            <TnIcon name="chevron-down" :size="16" />
                        </label>
                        <label class="directory-filter">
                            <span>Sort by</span>
                            <select v-model="sortOrder" aria-label="Sort tools">
                                <option value="sort_order">Recommended</option>
                                <option value="recent">Newest</option>
                                <option value="name">Name: A to Z</option>
                            </select>
                            <TnIcon name="chevron-down" :size="16" />
                        </label>
                    </div>
                    <label v-else class="directory-filter directory-category-sort">
                        <span>Sort by</span>
                        <select v-model="sortOrder" aria-label="Sort tools">
                            <option value="sort_order">Recommended</option>
                            <option value="recent">Newest</option>
                            <option value="name">Name: A to Z</option>
                        </select>
                        <TnIcon name="chevron-down" :size="16" />
                    </label>
                </div>

                <div class="directory-results-heading">
                    <h2>{{ isCategoryPage ? 'Available tools' : 'Browse all tools' }}</h2>
                    <span v-if="!isLoading">{{ totalTools }} {{ totalTools === 1 ? 'tool' : 'tools' }}</span>
                </div>

                <p v-if="toolsError" class="directory-message directory-error" role="alert">
                    Tools could not be loaded: {{ toolsError }}
                </p>
                <p v-else-if="isLoading" class="directory-message" role="status">
                    <span class="directory-search-spinner" aria-hidden="true" />
                    Loading tools…
                </p>
                <div v-else-if="tools.length" class="tool-grid">
                    <ToolCard v-for="tool in tools" :key="tool.id" :tool="tool" />
                </div>
                <TnEmptyState
                    v-else
                    :title="searchQuery ? 'No matching tools found' : 'No tools available yet'"
                    :description="searchQuery
                        ? 'Try another search term or clear your search to see all available tools.'
                        : 'There are no active tools in this selection yet.'"
                >
                    <template v-if="searchQuery" #action>
                        <button class="tn-btn tn-btn-secondary" type="button" @click="searchQuery = ''">
                            Clear search
                        </button>
                    </template>
                </TnEmptyState>

                <div v-if="!isLoading && lastPage > 1" class="directory-pagination">
                    <TnPagination :meta="pagination" @page-change="changePage" />
                </div>

                <section v-if="isCategoryPage && currentCategory && relatedCategories.length" class="directory-related">
                    <div class="directory-results-heading">
                        <h2>Related categories</h2>
                        <RouterLink :to="{ name: 'tools.index' }" class="text-link">View all tools</RouterLink>
                    </div>
                    <div class="directory-related-grid">
                        <RouterLink
                            v-for="category in relatedCategories"
                            :key="category.slug"
                            class="category-card"
                            :to="{ name: 'categories.show', params: { categorySlug: category.slug } }"
                        >
                            <span class="category-icon">
                                <TnIcon :name="category.icon" :size="20" />
                            </span>
                            <span class="category-copy">
                                <strong>{{ category.title }}</strong>
                                <span>{{ category.description }}</span>
                            </span>
                            <TnIcon name="arrow-up-right" :size="17" class="category-arrow" />
                        </RouterLink>
                    </div>
                </section>
            </div>
        </section>
    </MainLayout>
</template>
