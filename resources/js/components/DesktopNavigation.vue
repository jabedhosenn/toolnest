<script setup lang="ts">
import { RouterLink } from 'vue-router';
import CategoryDropdown from '@/components/CategoryDropdown.vue';

defineProps<{
    activeSection: string;
}>();

const links = [
    { title: 'Home', to: { name: 'home' }, id: 'top' },
    { title: 'All tools', to: { name: 'tools.index' }, id: 'popular-tools' },
    { title: 'Pricing', to: { name: 'home', hash: '#pricing' }, id: 'pricing' },
    { title: 'About', to: { name: 'home', hash: '#about' }, id: 'about' },
];
</script>

<template>
    <nav class="desktop-navigation" aria-label="Main navigation">
        <RouterLink
            v-for="link in links"
            :key="link.id"
            class="site-nav-link"
            :class="{ 'nav-link-active': activeSection === link.id }"
            :to="link.to"
            :aria-current="activeSection === link.id ? 'location' : undefined"
        >
            {{ link.title }}
        </RouterLink>
        <CategoryDropdown :active="activeSection === 'categories'" />
    </nav>
</template>
