<script setup lang="ts">
import { watch, onMounted, onUnmounted } from 'vue';

interface Props {
    modelValue: boolean;
    title?: string;
    size?: 'sm' | 'md' | 'lg';
    persistent?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    size: 'md',
    persistent: false,
});

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
}>();

function close(): void {
    if (!props.persistent) {
        emit('update:modelValue', false);
    }
}

function handleKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape') {
        close();
    }
}

watch(() => props.modelValue, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = '';
});

const sizeClass: Record<string, string> = {
    sm: 'max-w-sm',
    md: 'max-w-lg',
    lg: 'max-w-3xl',
};
</script>

<template>
    <Teleport to="body">
        <Transition name="tn-modal">
            <div
                v-if="modelValue"
                class="fixed inset-0 z-[1050] flex items-center justify-center p-4"
            >
                <!-- Backdrop -->
                <div
                    class="absolute inset-0"
                    style="background-color: rgb(0 0 0 / 0.5)"
                    @click="close"
                />

                <!-- Dialog -->
                <div
                    :class="[
                        'relative w-full',
                        sizeClass[size],
                    ]"
                    style="
                        background-color: var(--tn-surface);
                        border: 1px solid var(--tn-border);
                        border-radius: var(--tn-radius-lg);
                        box-shadow: var(--tn-shadow-xl);
                    "
                    role="dialog"
                    aria-modal="true"
                >
                    <!-- Header -->
                    <div
                        v-if="title || $slots.header"
                        class="flex items-center justify-between px-6 py-4"
                        style="border-bottom: 1px solid var(--tn-border)"
                    >
                        <slot name="header">
                            <h3 class="m-0 text-lg font-semibold">{{ title }}</h3>
                        </slot>
                        <button
                            class="tn-btn tn-btn-ghost tn-btn-icon"
                            aria-label="Close"
                            @click="close"
                        >
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-4">
                        <slot />
                    </div>

                    <!-- Footer -->
                    <div
                        v-if="$slots.footer"
                        class="flex items-center justify-end gap-3 px-6 py-4"
                        style="border-top: 1px solid var(--tn-border)"
                    >
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.tn-modal-enter-active,
.tn-modal-leave-active {
    transition: opacity 200ms ease;
}

.tn-modal-enter-active > div:last-child,
.tn-modal-leave-active > div:last-child {
    transition: transform 200ms ease, opacity 200ms ease;
}

.tn-modal-enter-from,
.tn-modal-leave-to {
    opacity: 0;
}

.tn-modal-enter-from > div:last-child {
    transform: scale(0.95) translateY(10px);
    opacity: 0;
}

.tn-modal-leave-to > div:last-child {
    transform: scale(0.95);
    opacity: 0;
}
</style>
