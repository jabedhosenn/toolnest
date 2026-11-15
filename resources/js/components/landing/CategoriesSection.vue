<script setup lang="ts">
import { RouterLink } from 'vue-router';
import type { ToolCategory } from '@/types/landing';
import SectionHeading from '@/components/landing/SectionHeading.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

defineProps<{
    categories: ToolCategory[];
}>();
</script>

<template>
    <section id="categories" class="content-section categories-section">
        <div class="tn-content">
            <SectionHeading
                eyebrow="Find your focus"
                title="Tools for every kind of task"
                description="Start with a category and find the right tool for what you need to get done."
            />
            <div class="category-grid">
                <RouterLink
                    v-for="category in categories"
                    :key="category.title"
                    class="category-card d-flex align-items-center"
                    :to="{ name: 'categories.show', params: { categorySlug: category.slug } }"
                >
                    <span class="category-icon"><TnIcon :name="category.icon" :size="21" /></span>
                    <span class="category-copy">
                        <strong>{{ category.title }}</strong>
                        <span>{{ category.description }}</span>
                    </span>
                    <TnIcon name="arrow-up-right" :size="17" class="category-arrow" />
                </RouterLink>
            </div>
        </div>
    </section>
</template>
