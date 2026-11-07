import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { AlertVariant, ToastMessage } from '@/types/design-system';

let toastIdCounter = 0;

export const useToastStore = defineStore('toast', () => {
    const toasts = ref<ToastMessage[]>([]);

    function addToast(
        message: string,
        options: { variant?: AlertVariant; title?: string; duration?: number } = {},
    ): string {
        const id = `toast-${++toastIdCounter}`;
        const toast: ToastMessage = {
            id,
            message,
            variant: options.variant ?? 'info',
            title: options.title,
            duration: options.duration ?? 5000,
        };

        toasts.value.push(toast);

        if (toast.duration > 0) {
            setTimeout(() => removeToast(id), toast.duration);
        }

        return id;
    }

    function removeToast(id: string): void {
        const index = toasts.value.findIndex((t) => t.id === id);
        if (index !== -1) {
            toasts.value.splice(index, 1);
        }
    }

    function success(message: string, title?: string): string {
        return addToast(message, { variant: 'success', title });
    }

    function warning(message: string, title?: string): string {
        return addToast(message, { variant: 'warning', title });
    }

    function error(message: string, title?: string): string {
        return addToast(message, { variant: 'danger', title });
    }

    function info(message: string, title?: string): string {
        return addToast(message, { variant: 'info', title });
    }

    function clearAll(): void {
        toasts.value = [];
    }

    return {
        toasts,
        addToast,
        removeToast,
        success,
        warning,
        error,
        info,
        clearAll,
    };
});
