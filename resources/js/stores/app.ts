import { defineStore } from 'pinia';
import { ref } from 'vue';
import { fetchApplicationStatus } from '@/services/status';
import type { ApplicationStatus } from '@/types/api';

export const useAppStore = defineStore('app', () => {
    const status = ref<ApplicationStatus | null>(null);
    const error = ref<string | null>(null);
    const isLoading = ref(false);

    async function loadStatus(): Promise<void> {
        isLoading.value = true;
        error.value = null;

        try {
            status.value = await fetchApplicationStatus();
        } catch {
            error.value = 'Unable to reach the ToolNest API.';
        } finally {
            isLoading.value = false;
        }
    }

    return {
        status,
        error,
        isLoading,
        loadStatus,
    };
});
