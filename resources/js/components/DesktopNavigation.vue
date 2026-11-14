<script setup lang="ts">
import CategoryDropdown from '@/components/CategoryDropdown.vue';

defineProps<{
    activeSection: string;
}>();

const links = [
    { title: 'Home', href: '#top', id: 'top' },
    { title: 'All tools', href: '#popular-tools', id: 'popular-tools' },
    { title: 'Pricing', href: '#pricing', id: 'pricing' },
    { title: 'About', href: '#about', id: 'about' },
];
</script>

<template>
    <nav class="desktop-navigation" aria-label="Main navigation">
        <a
            v-for="link in links.slice(0, 2)"
            :key="link.id"
            class="site-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :href="link.href"
            :aria-current="activeSection === link.id ? 'location' : undefined"
        >
            {{ link.title }}
        </a>
        <CategoryDropdown :active="activeSection === 'categories'" />
        <a
            v-for="link in links.slice(2)"
            :key="link.id"
            class="site-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :href="link.href"
            :aria-current="activeSection === link.id ? 'location' : undefined"
        >
            {{ link.title }}
        </a>
    </nav>
</template>
