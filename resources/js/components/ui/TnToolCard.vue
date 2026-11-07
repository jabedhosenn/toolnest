<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
    icon?: string;
    category?: string;
    href?: string;
}

defineProps<Props>();

defineEmits<{
    click: [];
}>();
</script>

<template>
    <div
        class="tn-card tn-card-interactive cursor-pointer"
        role="button"
        tabindex="0"
        @click="$emit('click')"
        @keydown.enter="$emit('click')"
    >
        <div class="tn-card-body">
            <div class="flex items-start gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg"
                    :style="{ backgroundColor: 'var(--tn-primary-light)', color: 'var(--tn-primary)' }"
                >
                    <slot name="icon">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76Z" />
                        </svg>
                    </slot>
                </div>
                <div class="min-w-0 flex-1">
                    <h4
                        class="m-0 text-base font-semibold"
                        :style="{ color: 'var(--tn-text)' }"
                    >
                        {{ title }}
                    </h4>
                    <p
                        v-if="description"
                        class="m-0 mt-1 text-sm tn-line-clamp-2"
                        :style="{ color: 'var(--tn-text-muted)' }"
                    >
                        {{ description }}
                    </p>
                    <span
                        v-if="category"
                        class="tn-badge tn-badge-secondary mt-2"
                    >
                        {{ category }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
