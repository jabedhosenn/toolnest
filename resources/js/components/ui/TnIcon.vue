<script setup lang="ts">
import type { IconName } from '@/types/landing';

withDefaults(
    defineProps<{
        name: IconName;
        size?: number;
        strokeWidth?: number;
    }>(),
    {
        size: 20,
        strokeWidth: 1.8,
    },
);

const iconPaths: Record<IconName, string[]> = {
    'arrow-down': ['M12 5v14', 'm19 12-7 7-7-7'],
    'arrow-right': ['M5 12h14', 'm12 5 7 7-7 7'],
    'arrow-up-right': ['M7 17 17 7', 'M7 7h10v10'],
    audio: [
        'M2 10v3',
        'M6 6v11',
        'M10 3v18',
        'M14 8v8',
        'M18 5v14',
        'M22 10v3',
    ],
    check: ['m5 12 4 4L19 6'],
    'chevron-down': ['m6 9 6 6 6-6'],
    clock: ['M12 8v4l3 2', 'M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z'],
    code: ['m16 18 6-6-6-6', 'm8 6-6 6 6 6', 'm14.5 4-5 16'],
    file: [
        'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z',
        'M14 2v6h6',
        'M8 13h8',
        'M8 17h8',
    ],
    files: [
        'M15 2H6a2 2 0 0 0-2 2v14',
        'M18 8V4a2 2 0 0 0-2-2',
        'M8 6h9a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z',
        'M10 12h5',
        'M10 16h5',
    ],
    grid: [
        'M3 3h7v7H3z',
        'M14 3h7v7h-7z',
        'M14 14h7v7h-7z',
        'M3 14h7v7H3z',
    ],
    image: [
        'M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z',
        'm3 16 5-5 4 4 4-6 5 7',
        'M8.5 8.5h.01',
    ],
    menu: ['M4 6h16', 'M4 12h16', 'M4 18h16'],
    moon: ['M20.985 12.486A9 9 0 1 1 11.51 3.015a7 7 0 0 0 9.475 9.471Z'],
    search: ['m21 21-4.34-4.34', 'M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z'],
    sparkles: [
        'm12 3 1.9 5.8L20 11l-6.1 2.2L12 19l-1.9-5.8L4 11l6.1-2.2L12 3Z',
        'm19 14 1.2 2.8L23 18l-2.8 1.2L19 22l-1.2-2.8L15 18l2.8-1.2L19 14Z',
        'm5 2 .8 1.8L8 4.5l-2.2.7L5 7l-.8-1.8L2 4.5l2.2-.7L5 2Z',
    ],
    sun: [
        'M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z',
        'M12 2v2',
        'M12 20v2',
        'm4.93 4.93 1.42 1.42',
        'm17.65 17.65 1.42 1.42',
        'M2 12h2',
        'M20 12h2',
        'm6.35 17.65-1.42 1.42',
        'm19.07 4.93-1.42 1.42',
    ],
    text: [
        'M4 7V4h16v3',
        'M9 20h6',
        'M12 4v16',
        'M5 12h3',
        'M16 12h3',
    ],
    upload: ['M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4', 'm17 8-5-5-5 5', 'M12 3v12'],
    video: [
        'M15 10l5.5-3.5a1 1 0 0 1 1.5.85v9.3a1 1 0 0 1-1.5.85L15 14',
        'M3 6h12v12H3z',
    ],
    wand: [
        'm15 4 5 5',
        'M12.5 6.5 17.5 11.5',
        'm3 21 9-9',
        'M4 4v3',
        'M2.5 5.5h3',
        'M19 14v3',
        'M17.5 15.5h3',
    ],
    x: ['M18 6 6 18', 'm6 6 12 12'],
    zap: ['m13 2-3 8h8l-7 12 2-9H5l8-11Z'],
};
</script>

<template>
    <svg
        :width="size"
        :height="size"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        :stroke-width="strokeWidth"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <path v-for="path in iconPaths[name]" :key="path" :d="path" />
    </svg>
</template>
