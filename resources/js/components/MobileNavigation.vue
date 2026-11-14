<script setup lang="ts">
import { nextTick, ref, watch } from 'vue';
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
    { title: 'Home', href: '#top', id: 'top' },
    { title: 'All tools', href: '#popular-tools', id: 'popular-tools' },
    { title: 'Pricing', href: '#pricing', id: 'pricing' },
    { title: 'About', href: '#about', id: 'about' },
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
        <a
            v-for="link in links.slice(0, 2)"
            :key="link.id"
            class="mobile-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :href="link.href"
            :aria-current="activeSection === link.id ? 'location' : undefined"
            @click="emit('close', false)"
        >
            {{ link.title }}
        </a>
        <CategoryDropdown
            variant="mobile"
            :active="activeSection === 'categories'"
            @select="emit('close', false)"
        />
        <a
            v-for="link in links.slice(2)"
            :key="link.id"
            class="mobile-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :href="link.href"
            :aria-current="activeSection === link.id ? 'location' : undefined"
            @click="emit('close', false)"
        >
            {{ link.title }}
        </a>

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
            <a class="tn-btn tn-btn-primary" href="#popular-tools" @click="emit('close', false)">
                Get started
                <TnIcon name="arrow-right" :size="16" />
            </a>
        </div>
    </nav>
</template>
