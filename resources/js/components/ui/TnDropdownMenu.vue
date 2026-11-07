<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import type { DropdownMenuItem } from '@/types/design-system';

interface Props {
    items: DropdownMenuItem[];
    align?: 'left' | 'right';
}

withDefaults(defineProps<Props>(), {
    align: 'left',
});

const emit = defineEmits<{
    select: [key: string];
}>();

const isOpen = ref(false);
const triggerRef = ref<HTMLElement | null>(null);
const menuRef = ref<HTMLElement | null>(null);

function toggle(): void {
    isOpen.value = !isOpen.value;
}

function select(item: DropdownMenuItem): void {
    if (item.disabled || item.divider) return;
    emit('select', item.key);
    isOpen.value = false;
}

function handleClickOutside(event: MouseEvent): void {
    const target = event.target as Node;
    if (
        triggerRef.value && !triggerRef.value.contains(target) &&
        menuRef.value && !menuRef.value.contains(target)
    ) {
        isOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="relative inline-block">
        <div ref="triggerRef" @click="toggle">
            <slot name="trigger">
                <button class="tn-btn tn-btn-secondary tn-btn-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1" /><circle cx="12" cy="5" r="1" /><circle cx="12" cy="19" r="1" />
                    </svg>
                </button>
            </slot>
        </div>

        <Transition name="tn-dropdown">
            <div
                v-if="isOpen"
                ref="menuRef"
                :class="[
                    'absolute z-50 mt-1 min-w-[12rem] py-1',
                    align === 'right' ? 'right-0' : 'left-0',
                ]"
                style="
                    background-color: var(--tn-surface);
                    border: 1px solid var(--tn-border);
                    border-radius: var(--tn-radius);
                    box-shadow: var(--tn-shadow-lg);
                "
                role="menu"
            >
                <template v-for="item in items" :key="item.key">
                    <hr
                        v-if="item.divider"
                        class="tn-divider my-1"
                    />
                    <button
                        v-else
                        :disabled="item.disabled"
                        :class="[
                            'flex w-full items-center gap-2 px-3 py-2 text-left text-sm',
                            item.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                        ]"
                        :style="{
                            color: item.danger ? 'var(--tn-danger)' : 'var(--tn-text)',
                            backgroundColor: 'transparent',
                            border: 'none',
                            transition: 'background-color var(--tn-transition-fast)',
                        }"
                        role="menuitem"
                        @click="select(item)"
                        @mouseenter="($event.target as HTMLElement).style.backgroundColor = 'var(--tn-surface-hover)'"
                        @mouseleave="($event.target as HTMLElement).style.backgroundColor = 'transparent'"
                    >
                        {{ item.label }}
                    </button>
                </template>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.tn-dropdown-enter-active,
.tn-dropdown-leave-active {
    transition: opacity 150ms ease, transform 150ms ease;
}

.tn-dropdown-enter-from,
.tn-dropdown-leave-to {
    opacity: 0;
    transform: translateY(-4px);
}
</style>
