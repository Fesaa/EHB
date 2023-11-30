import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
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
      children: [
        {
          path: "overview",
          name: "service-overview",
          component: () => import("../views/service/ServiceView.vue"),
        },
        {
          path: "session/:id",
          name: "session",
          component: () => import("../views/service/SessionView.vue"),
          children: [
            {
              path: "details",
              name: "session-details",
              component: () => import("../views/service/session/SessionDetailsView.vue"),
            },
            {
              path: "metrics",
              name: "session-metrics",
              component: () => import("../views/service/session/SessionMetricsView.vue"),
            }
          ]
        }
      ]
    },
  ]
})

export default router
