<script setup lang="ts">
import SectionHeading from '@/components/landing/SectionHeading.vue';
import TnIcon from '@/components/ui/TnIcon.vue';

const steps = [
    {
        number: '01',
        icon: 'grid' as const,
        title: 'Choose a tool',
        description: 'Find a tool that fits your task by browsing or searching the collection.',
    },
    {
        number: '02',
        icon: 'upload' as const,
        title: 'Add your content',
        description: 'Upload a file or enter the text you want to work with.',
    },
    {
        number: '03',
        icon: 'arrow-down' as const,
        title: 'Get your result',
        description: 'Process your content, then download or copy the finished result.',
    },
];
</script>

<template>
    <section id="how-it-works" class="how-it-works-section">
        <div class="tn-content">
            <SectionHeading
                eyebrow="A simple workflow"
                title="Three steps. That's it."
                description="A straightforward way to move from task to finished result."
                align="center"
            />
            <div class="steps-grid">
                <article v-for="step in steps" :key="step.number" class="step-card">
                    <span class="step-number">{{ step.number }}</span>
                    <span class="step-icon"><TnIcon :name="step.icon" :size="22" /></span>
                    <h3>{{ step.title }}</h3>
                    <p>{{ step.description }}</p>
                </article>
            </div>
        </div>
    </section>
</template>
