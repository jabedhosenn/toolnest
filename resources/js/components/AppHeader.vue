<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import BrandLogo from '@/components/landing/BrandLogo.vue';
import DesktopNavigation from '@/components/DesktopNavigation.vue';
import MobileNavigation from '@/components/MobileNavigation.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

const emit = defineEmits<{
    search: [];
}>();

const activeSection = ref('top');
const mobileMenuOpen = ref(false);
const menuButtonRef = ref<HTMLButtonElement | null>(null);

const sectionIds = ['top', 'popular-tools', 'categories', 'pricing', 'how-it-works', 'about'];

function updateActiveSection(): void {
    if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) {
        activeSection.value = 'about';
        return;
    }

    let currentSection = 'top';

    for (const sectionId of sectionIds) {
        const section = document.getElementById(sectionId);

        if (section && section.getBoundingClientRect().top <= 140) {
            currentSection = sectionId;
        }
    }

    activeSection.value = currentSection;
}

function closeMobileNavigation(restoreFocus = false): void {
    mobileMenuOpen.value = false;

    if (restoreFocus) {
        menuButtonRef.value?.focus();
    }
}

function handleViewportChange(): void {
    if (window.innerWidth > 800) {
        closeMobileNavigation();
    }
}

onMounted(() => {
    updateActiveSection();
    window.addEventListener('scroll', updateActiveSection, { passive: true });
    window.addEventListener('resize', updateActiveSection, { passive: true });
    window.addEventListener('resize', handleViewportChange, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', updateActiveSection);
    window.removeEventListener('resize', updateActiveSection);
    window.removeEventListener('resize', handleViewportChange);
});
</script>

<template>
    <header class="site-header">
        <div class="site-nav tn-content">
            <RouterLink to="/" class="brand-link" aria-label="ToolNest home">
                <BrandLogo />
            </RouterLink>

            <DesktopNavigation
                :active-section="activeSection"
            />

            <div class="header-actions">
                <button
                    class="icon-button nav-search-button"
                    type="button"
                    aria-label="Search tools"
                    @click="emit('search')"
                >
                    <TnIcon name="search" />
                </button>
                <ThemeToggle />
                <a class="login-link" href="/login">Log in</a>
                <a class="tn-btn tn-btn-primary get-started-button" href="#popular-tools">
                    Get started
                    <TnIcon name="arrow-right" :size="16" />
                </a>
            </div>

            <button
                ref="menuButtonRef"
                class="icon-button mobile-menu-button"
                type="button"
                aria-controls="mobile-navigation"
                :aria-expanded="mobileMenuOpen"
                :aria-label="mobileMenuOpen ? 'Close navigation menu' : 'Open navigation menu'"
                @click="mobileMenuOpen = !mobileMenuOpen"
            >
                <TnIcon :name="mobileMenuOpen ? 'x' : 'menu'" />
            </button>
        </div>

        <MobileNavigation
            :open="mobileMenuOpen"
            :active-section="activeSection"
            @close="closeMobileNavigation"
            @search="emit('search')"
        />
    </header>
</template>
