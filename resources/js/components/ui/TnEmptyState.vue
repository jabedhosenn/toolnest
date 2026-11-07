<script setup lang="ts">
interface Props {
    title?: string;
    description?: string;
    icon?: boolean;
}

withDefaults(defineProps<Props>(), {
    title: 'No results found',
    description: 'Try adjusting your search or filters.',
    icon: true,
});
</script>

<template>
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div
            v-if="icon"
            class="mb-4 flex h-16 w-16 items-center justify-center rounded-full"
            :style="{ backgroundColor: 'var(--tn-surface-hover)' }"
        >
            <slot name="icon">
                <svg
                    width="28"
                    height="28"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    :style="{ color: 'var(--tn-text-muted)' }"
                >
                    <path d="M21 21l-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </slot>
        </div>
        <h3
            class="mb-2 text-lg font-semibold"
            :style="{ color: 'var(--tn-text)' }"
        >
            {{ title }}
        </h3>
        <p
            class="mb-4 max-w-sm text-sm"
            :style="{ color: 'var(--tn-text-muted)' }"
        >
            {{ description }}
        </p>
        <slot name="action" />
    </div>
</template>
