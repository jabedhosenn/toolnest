<script setup lang="ts">
import BrandLogo from '@/components/landing/BrandLogo.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

const categoryLinks = [
    { title: 'Text Tools', href: '#category-text-tools' },
    { title: 'PDF Tools', href: '#category-pdf-tools' },
    { title: 'Image Tools', href: '#category-image-tools' },
    { title: 'Developer Tools', href: '#category-developer-tools' },
];

const companyLinks = [
    { title: 'About ToolNest', href: '#about' },
    { title: 'How it works', href: '#how-it-works' },
    { title: 'Pricing', href: '#pricing' },
];

const helpLinks = [
    { title: 'Help & support', href: '#how-it-works' },
    { title: 'Privacy policy', href: '/privacy-policy' },
    { title: 'Terms of service', href: '/terms-of-service' },
];
</script>

<template>
    <footer id="about" class="site-footer">
        <div class="tn-content">
            <div class="footer-main">
                <div class="footer-brand-column">
                    <a class="footer-brand" href="#top" aria-label="ToolNest home">
                        <BrandLogo />
                    </a>
                    <p>
                        A thoughtfully gathered set of tools for the little tasks that make up
                        your day.
                    </p>
                </div>

                <div class="footer-link-column">
                    <h2>Explore</h2>
                    <a v-for="link in categoryLinks" :key="link.title" :href="link.href">
                        {{ link.title }}
                    </a>
                </div>

                <div id="pricing" class="footer-link-column">
                    <h2>Company</h2>
                    <a v-for="link in companyLinks" :key="link.title" :href="link.href">
                        {{ link.title }}
                    </a>
                </div>

                <div class="footer-link-column">
                    <h2>Help &amp; legal</h2>
                    <a v-for="link in helpLinks" :key="link.title" :href="link.href">
                        {{ link.title }}
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© {{ new Date().getFullYear() }} ToolNest. All rights reserved.</span>
                <a class="back-to-top" href="#top">
                    Back to top <TnIcon name="arrow-up-right" :size="15" />
                </a>
            </div>
        </div>
    </footer>
</template>
