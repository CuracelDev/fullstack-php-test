import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },

    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('../views/dashboard'),
    },

    {
        path: '/coupons',
        name: 'Coupons',
        component: () => import ('../views/coupons'),
    },

    {
        path: '/orders',
        name: 'Orders',
        component: () => import('../views/orders'),
    },

    {
        path: '/shop',
        name: 'Shop',
        component: () => import('../views/shop'),
    },

    {
        path: '/cart',
        name: 'Cart',
        component: () => import('../views/cart'),
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;