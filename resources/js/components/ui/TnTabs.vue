<script setup lang="ts">
import type { TabItem } from '@/types/design-system';

interface Props {
    modelValue: string;
    tabs: TabItem[];
}

defineProps<Props>();

defineEmits<{
    'update:modelValue': [value: string];
}>();
</script>

<template>
    <div class="tn-tabs" role="tablist">
        <button
            v-for="tab in tabs"
            :key="tab.key"
            :class="['tn-tab', { 'tn-tab-active': modelValue === tab.key }]"
            :disabled="tab.disabled"
            :aria-selected="modelValue === tab.key"
            role="tab"
            @click="$emit('update:modelValue', tab.key)"
        >
            {{ tab.label }}
        </button>
    </div>
</template>
