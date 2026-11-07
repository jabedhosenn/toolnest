<script setup lang="ts">
interface Props {
    width?: string;
    height?: string;
    circle?: boolean;
}

withDefaults(defineProps<Props>(), {
    width: '100%',
    height: '1rem',
    circle: false,
});
</script>

<template>
    <div
        class="tn-skeleton"
        :style="{
            width,
            height,
            borderRadius: circle ? 'var(--tn-radius-full)' : undefined,
        }"
    />
</template>
