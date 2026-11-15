<script setup lang="ts">
import { ref } from 'vue';
import TnIcon from '@/components/ui/TnIcon.vue';

withDefaults(
    defineProps<{
        suggestions: string[];
        loading?: boolean;
        placeholder?: string;
    }>(),
    {
        loading: false,
        placeholder: 'Search tools by name, description, or tag',
    },
);

const query = defineModel<string>({ default: '' });
const suggestionsOpen = ref(false);

function selectSuggestion(suggestion: string): void {
    query.value = suggestion;
    suggestionsOpen.value = false;
}

function clearSearch(): void {
    query.value = '';
    suggestionsOpen.value = false;
}
</script>

<template>
    <div class="directory-search">
        <form class="directory-search-form" role="search" @submit.prevent>
            <TnIcon name="search" :size="21" />
            <input
                v-model="query"
                type="search"
                :placeholder="placeholder"
                aria-label="Search tools by name, description, or tag"
                autocomplete="off"
                aria-autocomplete="list"
                :aria-expanded="suggestionsOpen && suggestions.length > 0"
                aria-controls="tool-search-suggestions"
                @focus="suggestionsOpen = true"
                @keydown.esc="suggestionsOpen = false"
            />
            <span v-if="loading" class="directory-search-spinner" role="status" aria-label="Searching" />
            <button
                v-else-if="query"
                class="directory-search-clear"
                type="button"
                aria-label="Clear search"
                @click="clearSearch"
            >
                <TnIcon name="x" :size="18" />
            </button>
        </form>

        <ul
            v-if="suggestionsOpen && query.trim() && suggestions.length"
            id="tool-search-suggestions"
            class="directory-search-suggestions"
            role="listbox"
            aria-label="Search suggestions"
        >
            <li v-for="suggestion in suggestions" :key="suggestion" role="option" aria-selected="false">
                <button type="button" @mousedown.prevent="selectSuggestion(suggestion)">
                    <TnIcon name="search" :size="16" />
                    <span>{{ suggestion }}</span>
                </button>
            </li>
        </ul>
    </div>
</template>
