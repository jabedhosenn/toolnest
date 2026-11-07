<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import BrandLogo from '@/components/landing/BrandLogo.vue';
import TnIcon from '@/components/ui/TnIcon.vue';
import TnThemeToggle from '@/components/ui/TnThemeToggle.vue';

const emit = defineEmits<{
    search: [];
}>();

const mobileMenuOpen = ref(false);
const categoriesOpen = ref(false);

function closeMenus(): void {
    mobileMenuOpen.value = false;
    categoriesOpen.value = false;
}
</script>

<template>
    <header class="site-header">
        <nav class="site-nav tn-content" aria-label="Main navigation">
            <RouterLink to="/" class="brand-link" aria-label="ToolNest home" @click="closeMenus">
                <BrandLogo />
            </RouterLink>

            <div class="desktop-nav">
                <a class="site-nav-link" href="#top">Home</a>
                <a class="site-nav-link" href="#popular-tools">All Tools</a>
                <div class="nav-dropdown">
                    <button
                        class="site-nav-link nav-dropdown-trigger"
                        type="button"
                        :aria-expanded="categoriesOpen"
                        @click="categoriesOpen = !categoriesOpen"
                    >
                        Categories
                        <TnIcon name="chevron-down" :size="15" />
                    </button>
                    <div v-if="categoriesOpen" class="nav-dropdown-menu">
                        <a href="#categories" @click="closeMenus">Browse all categories</a>
                        <a href="#category-text-tools" @click="closeMenus">Text Tools</a>
                        <a href="#category-pdf-tools" @click="closeMenus">PDF Tools</a>
                        <a href="#category-image-tools" @click="closeMenus">Image Tools</a>
                    </div>
                </div>
                <a class="site-nav-link" href="#pricing">Pricing</a>
                <a class="site-nav-link" href="#about">About</a>
            </div>

            <div class="nav-actions">
                <button
                    class="icon-button nav-search-button"
                    type="button"
                    aria-label="Search tools"
                    @click="emit('search')"
                >
                    <TnIcon name="search" />
                </button>
                <TnThemeToggle />
                <a class="login-link" href="/login">Log in</a>
                <a class="tn-btn tn-btn-primary get-started-button" href="#popular-tools">
                    Get started
                    <TnIcon name="arrow-right" :size="16" />
                </a>
            </div>

            <button
                class="icon-button mobile-menu-button"
                type="button"
                :aria-label="mobileMenuOpen ? 'Close navigation menu' : 'Open navigation menu'"
                :aria-expanded="mobileMenuOpen"
                @click="mobileMenuOpen = !mobileMenuOpen"
            >
                <TnIcon :name="mobileMenuOpen ? 'x' : 'menu'" />
            </button>
        </nav>

        <div v-if="mobileMenuOpen" class="mobile-nav tn-content">
            <a href="#top" @click="closeMenus">Home</a>
            <a href="#popular-tools" @click="closeMenus">All Tools</a>
            <a href="#categories" @click="closeMenus">Categories</a>
            <a href="#pricing" @click="closeMenus">Pricing</a>
            <a href="#about" @click="closeMenus">About</a>
            <div class="mobile-nav-actions">
                <button
                    class="icon-button mobile-action-button"
                    type="button"
                    aria-label="Search tools"
                    @click="closeMenus(); emit('search')"
                >
                    <TnIcon name="search" />
                </button>
                <TnThemeToggle />
                <a class="tn-btn tn-btn-secondary" href="/login" @click="closeMenus">Log in</a>
                <a class="tn-btn tn-btn-primary" href="#popular-tools" @click="closeMenus">
                    Get started
                    <TnIcon name="arrow-right" :size="16" />
                </a>
            </div>
        </div>
    </header>
</template>
