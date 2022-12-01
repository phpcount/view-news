import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    name: 'home',
    path: '/',
    component: () => import('@/views/HomeView.vue')
  },
  {
    name: 'post',
    path: '/post/:id',
    component: () => import('@/views/PostView.vue')
  },
  {
    name: 'settings',
    path: '/settings',
    component: () => import('@/views/SettingsView.vue')
  },
  {
    path: '/:any(.*)',
    component: () => import('@/views/E404View.vue')
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
