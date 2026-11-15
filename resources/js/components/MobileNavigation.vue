<script setup lang="ts">
import { nextTick, ref, watch } from 'vue';
import { RouterLink } from 'vue-router';
import CategoryDropdown from '@/components/CategoryDropdown.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

const props = defineProps<{
    open: boolean;
    activeSection: string;
}>();

const emit = defineEmits<{
    close: [restoreFocus: boolean];
    search: [];
}>();

const panelRef = ref<HTMLElement | null>(null);
const links = [
    { title: 'Home', to: { name: 'home' }, id: 'top' },
    { title: 'All tools', to: { name: 'tools.index' }, id: 'popular-tools' },
    { title: 'Pricing', to: { name: 'home', hash: '#pricing' }, id: 'pricing' },
    { title: 'About', to: { name: 'home', hash: '#about' }, id: 'about' },
];

function handleKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape') {
        event.preventDefault();
        emit('close', true);
    }
}

function handleSearch(): void {
    emit('close', false);
    emit('search');
}

watch(
    () => props.open,
    async (isOpen) => {
        if (isOpen) {
            await nextTick();
            panelRef.value?.querySelector<HTMLElement>('a[href], button:not([disabled])')?.focus();
        }
    },
);
</script>

<template>
    <nav
        v-if="open"
        id="mobile-navigation"
        ref="panelRef"
        class="mobile-navigation"
        aria-label="Mobile navigation"
        @keydown="handleKeydown"
    >
        <RouterLink
            v-for="link in links"
            :key="link.id"
            class="mobile-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :to="link.to"
            :aria-current="activeSection === link.id ? 'location' : undefined"
            @click="emit('close', false)"
        >
            {{ link.title }}
        </RouterLink>
        <CategoryDropdown
            variant="mobile"
            :active="activeSection === 'categories'"
            @select="emit('close', false)"
        />
        <div class="mobile-navigation-actions">
            <button
                class="icon-button mobile-navigation-icon"
                type="button"
                aria-label="Search tools"
                @click="handleSearch"
            >
                <TnIcon name="search" />
            </button>
            <ThemeToggle />
            <a class="tn-btn tn-btn-secondary" href="/login" @click="emit('close', false)">
                Log in
            </a>
            <RouterLink
                class="tn-btn tn-btn-primary"
                :to="{ name: 'tools.index' }"
                @click="emit('close', false)"
            >
                Get started
                <TnIcon name="arrow-right" :size="16" />
            </RouterLink>
        </div>
    </nav>
</template>
