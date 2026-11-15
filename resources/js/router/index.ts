import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '@/pages/HomePage.vue';
import ToolsDirectoryPage from '@/pages/ToolsDirectoryPage.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomePage,
        },
        {
            path: '/tools',
            name: 'tools.index',
            component: ToolsDirectoryPage,
        },
        {
            path: '/categories/:categorySlug',
            name: 'categories.show',
            component: ToolsDirectoryPage,
            props: true,
        },
    ],
});

export default router;
