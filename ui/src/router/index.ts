import { createRouter, createWebHistory } from 'vue-router'
import Checkout from '../views/Checkout.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'checkout',
      component: Checkout
    },
  ]
})

export default router
