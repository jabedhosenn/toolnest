<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
    count?: number;
}

defineProps<Props>();

defineEmits<{
    click: [];
}>();
</script>

<template>
    <div
        class="tn-card tn-card-interactive cursor-pointer text-center"
        role="button"
        tabindex="0"
        @click="$emit('click')"
        @keydown.enter="$emit('click')"
    >
        <div class="tn-card-body">
            <div
                class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl"
                :style="{ backgroundColor: 'var(--tn-primary-light)', color: 'var(--tn-primary)' }"
            >
                <slot name="icon">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                </slot>
            </div>
            <h4
                class="m-0 text-base font-semibold"
                :style="{ color: 'var(--tn-text)' }"
            >
                {{ title }}
            </h4>
            <p
                v-if="description"
                class="m-0 mt-1 text-sm"
                :style="{ color: 'var(--tn-text-muted)' }"
            >
                {{ description }}
            </p>
            <span
                v-if="count !== undefined"
                class="mt-2 inline-block text-xs font-medium"
                :style="{ color: 'var(--tn-text-muted)' }"
            >
                {{ count }} {{ count === 1 ? 'tool' : 'tools' }}
            </span>
        </div>
    </div>
</template>
