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
      component: () => import("../views/service/ServiceView.vue")
    },
    {
      path: "/service/:name/:id/details",
      name: "service-id",
      component: () => import("../views/service/SessionView.vue"),
      props(to) {
        return {
          session: to.params.id,
          name: to.params.name
        }
      },
    },
    {
      path: "/service/:name/:id/metrics",
      name: "service-id",
      component: () => import("../views/service/SessionView.vue"),
      props(to) {
        return {
          session: to.params.id,
          name: to.params.name
        }
      },
    },
  ]
})

export default router
