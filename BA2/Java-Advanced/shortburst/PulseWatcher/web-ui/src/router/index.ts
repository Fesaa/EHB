import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'overview',
      component: HomeView
    },
    {
      path: "/overview",
      name: "overview",
      component: () => import("../views/OverviewView.vue")
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: "/service/:name",
      name: "service",
      component: () => import("../views/ServiceView.vue")
    },
    {
      path: "/service/:name/:id",
      name: "service-id",
      component: () => import("../views/SessionView.vue")
    }
  ]
})

export default router
