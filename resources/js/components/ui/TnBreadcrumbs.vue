<script setup lang="ts">
import { RouterLink } from 'vue-router';
import type { BreadcrumbItem } from '@/types/design-system';

interface Props {
    items: BreadcrumbItem[];
}

defineProps<Props>();
</script>

<template>
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5 text-sm" style="list-style: none; margin: 0; padding: 0">
            <li
                v-for="(item, index) in items"
                :key="index"
                class="flex items-center gap-1.5"
            >
                <svg
                    v-if="index > 0"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    :style="{ color: 'var(--tn-text-muted)' }"
                >
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <RouterLink
                    v-if="item.to && !item.active"
                    :to="item.to"
                    :style="{ color: 'var(--tn-text-muted)' }"
                    class="hover:underline"
                    style="transition: color var(--tn-transition-fast)"
                >
                    {{ item.label }}
                </RouterLink>
                <span
                    v-else
                    class="font-medium"
                    :style="{ color: item.active ? 'var(--tn-text)' : 'var(--tn-text-muted)' }"
                >
                    {{ item.label }}
                </span>
            </li>
        </ol>
    </nav>
</template>
