<script setup lang="ts">
import { useThemeStore } from '@/stores/theme';
import TnIcon from '@/components/ui/TnIcon.vue';

const themeStore = useThemeStore();
</script>

<template>
    <button
        class="icon-button theme-toggle"
        type="button"
        :aria-label="`Switch to ${themeStore.isDark ? 'light' : 'dark'} theme`"
        :title="`Current: ${themeStore.preference} theme`"
        @click="themeStore.toggleTheme()"
    >
        <TnIcon :name="themeStore.isDark ? 'sun' : 'moon'" :size="18" />
    </button>
</template>
