<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref, useId } from 'vue';
import { toolCategories } from '@/data/toolCategories';
import TnIcon from '@/components/ui/TnIcon.vue';

withDefaults(
    defineProps<{
        active?: boolean;
        variant?: 'desktop' | 'mobile';
    }>(),
    {
        active: false,
        variant: 'desktop',
    },
);

const emit = defineEmits<{
    select: [];
}>();

const isOpen = ref(false);
const dropdownRef = ref<HTMLElement | null>(null);
const triggerRef = ref<HTMLButtonElement | null>(null);
const panelId = useId();

function closeDropdown(restoreFocus = false): void {
    isOpen.value = false;

    if (restoreFocus) {
        triggerRef.value?.focus();
    }
}

function handleDocumentClick(event: MouseEvent): void {
    if (event.target instanceof Node && !dropdownRef.value?.contains(event.target)) {
        closeDropdown();
    }
}

function handleKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape' && isOpen.value) {
        event.stopPropagation();
        closeDropdown(true);
    }
}

function selectCategory(): void {
    closeDropdown();
    emit('select');
}

onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<template>
    <div
        ref="dropdownRef"
        class="category-dropdown"
        :class="`category-dropdown-${variant}`"
        @keydown="handleKeydown"
    >
        <button
            ref="triggerRef"
            class="site-nav-link nav-dropdown-trigger"
            :class="{ 'nav-link-active': active, 'mobile-nav-link': variant === 'mobile' }"
            type="button"
            :aria-current="active ? 'location' : undefined"
            :aria-expanded="isOpen"
            :aria-controls="panelId"
            @click="isOpen = !isOpen"
        >
            Categories
            <TnIcon
                name="chevron-down"
                :size="15"
                class="category-dropdown-chevron"
                :class="{ 'category-dropdown-chevron-open': isOpen }"
            />
        </button>
        <div
            v-if="isOpen"
            :id="panelId"
            class="category-dropdown-panel"
            :class="{ 'category-dropdown-panel-mobile': variant === 'mobile' }"
            aria-label="Tool categories"
        >
            <a
                v-for="category in toolCategories"
                :key="category.id"
                class="category-dropdown-item"
                :href="`#category-${category.id}`"
                @click="selectCategory"
            >
                <span class="category-dropdown-icon">
                    <TnIcon :name="category.icon" :size="18" />
                </span>
                <span class="category-dropdown-copy">
                    <strong>{{ category.title }}</strong>
                    <span>{{ category.description }}</span>
                </span>
                <TnIcon name="arrow-up-right" :size="15" class="category-dropdown-arrow" />
            </a>
        </div>
    </div>
</template>
