import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import Login from '../Pages/login.vue';
import Secure from '../Secure/secure.vue';
import Checkout from '../Secure/Cart/Checkout.vue';
import Coupons from '../Secure/coupon/Coupons.vue';
import Products from '../Secure/products/Products.vue';

const routes = [
  {path: '/login', component: Login},
  {
    path:'/',
    component: Secure,
    children: [
      {path:'/checkout', component: Checkout},
      {path:'/coupons', component: Coupons},
      {path:'/products', component: Products},
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router