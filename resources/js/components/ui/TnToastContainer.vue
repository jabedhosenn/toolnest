<script setup lang="ts">
import { useToastStore } from '@/stores/toast';

const toastStore = useToastStore();

const iconMap: Record<string, string> = {
    success: 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4 12 14.01l-3-3',
    warning: 'm21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3ZM12 9v4M12 17h.01',
    danger: 'M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10ZM15 9l-6 6M9 9l6 6',
    info: 'M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10ZM12 16v-4M12 8h.01',
};
</script>

<template>
    <Teleport to="body">
        <div class="tn-toast-container">
            <TransitionGroup name="tn-toast">
                <div
                    v-for="toast in toastStore.toasts"
                    :key="toast.id"
                    :class="['tn-alert', `tn-alert-${toast.variant}`]"
                    style="min-width: 320px; max-width: 420px; box-shadow: var(--tn-shadow-lg)"
                    role="alert"
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="shrink-0 mt-0.5"
                    >
                        <path :d="iconMap[toast.variant]" />
                    </svg>
                    <div class="flex-grow-1 min-w-0">
                        <p v-if="toast.title" class="m-0 mb-0.5 text-sm font-semibold">
                            {{ toast.title }}
                        </p>
                        <p class="m-0 text-sm">{{ toast.message }}</p>
                    </div>
                    <button
                        class="tn-btn tn-btn-ghost tn-btn-icon shrink-0"
                        style="width: 1.5rem; height: 1.5rem; padding: 0"
                        aria-label="Dismiss"
                        @click="toastStore.removeToast(toast.id)"
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<style scoped>
.tn-toast-enter-active,
.tn-toast-leave-active {
    transition: all 200ms ease;
}

.tn-toast-enter-from {
    opacity: 0;
    transform: translateX(100%);
}

.tn-toast-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

.tn-toast-move {
    transition: transform 200ms ease;
}
</style>
