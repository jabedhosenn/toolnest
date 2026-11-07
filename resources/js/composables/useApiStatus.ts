import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';
import { useAppStore } from '@/stores/app';

export function useApiStatus() {
    const store = useAppStore();
    const { status, error, isLoading } = storeToRefs(store);

    onMounted(() => {
        void store.loadStatus();
    });

    return {
        status,
        error,
        isLoading,
        refresh: store.loadStatus,
    };
}
