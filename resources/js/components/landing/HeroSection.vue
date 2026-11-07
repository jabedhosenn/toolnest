<script setup lang="ts">
import { ref } from 'vue';
import TnIcon from '@/components/ui/TnIcon.vue';

const query = defineModel<string>({ default: '' });
const emit = defineEmits<{
    search: [query: string];
}>();

const searchInput = ref<HTMLInputElement | null>(null);
const suggestions = ['Word counter', 'PDF compressor', 'Image converter', 'JSON formatter'];

function submitSearch(): void {
    emit('search', query.value.trim());
}

function selectSuggestion(suggestion: string): void {
    query.value = suggestion;
    submitSearch();
}

function focusSearch(): void {
    searchInput.value?.focus();
}

defineExpose({ focusSearch });
</script>

<template>
    <section id="top" class="hero-section">
        <div class="hero-orb hero-orb-one" aria-hidden="true"></div>
        <div class="hero-orb hero-orb-two" aria-hidden="true"></div>
        <div class="tn-content hero-content">
            <div class="hero-copy">
                <span class="hero-kicker flex items-center gap-2">
                    <TnIcon name="sparkles" :size="15" />
                    A little more ease in your day
                </span>
                <h1>All Your Everyday Tools <span>in One Place</span></h1>
                <p class="hero-description">
                    Convert files, edit PDFs, transform text, and simplify everyday tasks with fast
                    and easy online tools.
                </p>

                <form id="hero-search" class="hero-search" role="search" @submit.prevent="submitSearch">
                    <TnIcon name="search" :size="21" />
                    <input
                        ref="searchInput"
                        v-model="query"
                        type="search"
                        placeholder="What would you like to do?"
                        aria-label="Search tools"
                    />
                    <button class="tn-btn tn-btn-primary hero-search-submit" type="submit">
                        <span>Search</span>
                        <TnIcon name="arrow-right" :size="16" />
                        <TnIcon name="search" :size="18" class="hero-mobile-search-icon" />
                    </button>
                </form>

                <div class="popular-searches">
                    <span>Popular:</span>
                    <button
                        v-for="suggestion in suggestions"
                        :key="suggestion"
                        type="button"
                        @click="selectSuggestion(suggestion)"
                    >
                        {{ suggestion }}
                    </button>
                </div>

                <div class="hero-actions">
                    <a class="tn-btn tn-btn-primary tn-btn-lg" href="#popular-tools">
                        Explore all tools
                        <TnIcon name="arrow-right" :size="17" />
                    </a>
                    <a class="tn-btn tn-btn-secondary tn-btn-lg" href="#categories">
                        Explore categories
                    </a>
                </div>
            </div>

            <div class="hero-note">
                <span class="hero-note-icon"><TnIcon name="zap" :size="18" /></span>
                <span><strong>Made for everyday tasks</strong><br />Simple tools, easy workflows.</span>
            </div>
        </div>
    </section>
</template>
