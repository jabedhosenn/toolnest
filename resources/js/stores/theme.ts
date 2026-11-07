import { defineStore } from 'pinia';
import { ref, computed, watch } from 'vue';

export type ThemePreference = 'light' | 'dark' | 'system';
export type ResolvedTheme = 'light' | 'dark';

const STORAGE_KEY = 'toolnest-theme';

function getSystemTheme(): ResolvedTheme {
    if (typeof window === 'undefined') return 'light';
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function loadPreference(): ThemePreference {
    if (typeof window === 'undefined') return 'system';
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored === 'light' || stored === 'dark' || stored === 'system') return stored;
    return 'system';
}

export const useThemeStore = defineStore('theme', () => {
    const preference = ref<ThemePreference>(loadPreference());
    const systemTheme = ref<ResolvedTheme>(getSystemTheme());

    const resolvedTheme = computed<ResolvedTheme>(() =>
        preference.value === 'system' ? systemTheme.value : preference.value,
    );

    const isDark = computed(() => resolvedTheme.value === 'dark');

    function applyTheme(): void {
        const theme = resolvedTheme.value;
        document.documentElement.setAttribute('data-theme', theme);

        // Also set color-scheme for native elements
        document.documentElement.style.colorScheme = theme;
    }

    function setPreference(value: ThemePreference): void {
        preference.value = value;
        localStorage.setItem(STORAGE_KEY, value);
        applyTheme();
    }

    function toggleTheme(): void {
        const next: ThemePreference = resolvedTheme.value === 'dark' ? 'light' : 'dark';
        setPreference(next);
    }

    function cycleTheme(): void {
        const order: ThemePreference[] = ['light', 'dark', 'system'];
        const currentIndex = order.indexOf(preference.value);
        const nextIndex = (currentIndex + 1) % order.length;
        setPreference(order[nextIndex]);
    }

    function init(): void {
        applyTheme();

        // Listen for system preference changes
        if (typeof window !== 'undefined') {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (event) => {
                systemTheme.value = event.matches ? 'dark' : 'light';
                if (preference.value === 'system') {
                    applyTheme();
                }
            });
        }
    }

    // Watch for reactive changes
    watch(resolvedTheme, () => {
        applyTheme();
    });

    return {
        preference,
        resolvedTheme,
        isDark,
        setPreference,
        toggleTheme,
        cycleTheme,
        init,
    };
});
