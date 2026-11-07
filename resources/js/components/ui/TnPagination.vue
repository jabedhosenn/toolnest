<script setup lang="ts">
import { computed } from 'vue';
import type { PaginationMeta } from '@/types/design-system';

interface Props {
    meta: PaginationMeta;
    maxVisible?: number;
}

const props = withDefaults(defineProps<Props>(), {
    maxVisible: 7,
});

const emit = defineEmits<{
    'page-change': [page: number];
}>();

const pages = computed(() => {
    const { currentPage, lastPage } = props.meta;
    const max = props.maxVisible;

    if (lastPage <= max) {
        return Array.from({ length: lastPage }, (_, i) => i + 1);
    }

    const half = Math.floor(max / 2);
    let start = Math.max(currentPage - half, 1);
    const end = Math.min(start + max - 1, lastPage);

    if (end - start + 1 < max) {
        start = Math.max(end - max + 1, 1);
    }

    const result: (number | string)[] = [];

    if (start > 1) {
        result.push(1);
        if (start > 2) result.push('...');
    }

    for (let i = start; i <= end; i++) {
        result.push(i);
    }

    if (end < lastPage) {
        if (end < lastPage - 1) result.push('...');
        result.push(lastPage);
    }

    return result;
});

function goToPage(page: number): void {
    if (page >= 1 && page <= props.meta.lastPage && page !== props.meta.currentPage) {
        emit('page-change', page);
    }
}
</script>

<template>
    <nav class="flex items-center gap-1" aria-label="Pagination">
        <!-- Previous -->
        <button
            class="tn-btn tn-btn-ghost tn-btn-icon tn-btn-sm"
            :disabled="meta.currentPage <= 1"
            aria-label="Previous page"
            @click="goToPage(meta.currentPage - 1)"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </button>

        <!-- Pages -->
        <template v-for="(page, index) in pages" :key="index">
            <span
                v-if="page === '...'"
                class="px-2 text-sm"
                :style="{ color: 'var(--tn-text-muted)' }"
            >
                …
            </span>
            <button
                v-else
                :class="[
                    'tn-btn tn-btn-sm',
                    page === meta.currentPage ? 'tn-btn-primary' : 'tn-btn-ghost',
                ]"
                style="min-width: 2rem"
                @click="goToPage(page as number)"
            >
                {{ page }}
            </button>
        </template>

        <!-- Next -->
        <button
            class="tn-btn tn-btn-ghost tn-btn-icon tn-btn-sm"
            :disabled="meta.currentPage >= meta.lastPage"
            aria-label="Next page"
            @click="goToPage(meta.currentPage + 1)"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
        </button>
    </nav>
</template>
