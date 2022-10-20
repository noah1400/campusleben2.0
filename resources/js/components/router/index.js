import { createRouter, createWebHistory } from 'vue-router';
import dashboardLayout from '../layouts/dashboardLayout.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'dashboard-parent',
            path: '/admin/dashboard/',
            params: { tab: 'dashboard' },
            component: dashboardLayout,
            children: [
                {
                    name: 'dashboard',
                    path: 'dashboard',
                    component: dashboardLayout
                },
                {
                    name: 'events',
                    path: 'events',
                    component: dashboardLayout
                },
                {
                    name: 'users',
                    path: 'users',
                    component: dashboardLayout
                },
                {
                    name: 'sponsors',
                    path: 'sponsors',
                    component: dashboardLayout
                }
            ]
        }
    ]
});

export default router;