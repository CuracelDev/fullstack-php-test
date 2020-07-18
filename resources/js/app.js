require('./bootstrap');

import Vue from "vue";
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import App from "@/App.vue";
import Login from '@/components/users/Login.vue';
import Register from '@/components/users/Register.vue';
import AddCoupon from '@/components/coupons/AddCoupon.vue';
import Coupons from '@/components/coupons/Coupons.vue';
import Products from '@/components/products/Products.vue';
import Orders from '@/components/orders/Orders.vue';
import Functions from '@/components/functions';

const routes = [
    {
        path: '/', 
        component: Login, 
        name: 'login'
    },
    {
        path: '/register', 
        component: Register, 
        name: 'register'
    },
    {
        path: '/coupons/add', 
        component: AddCoupon, 
        name: 'addCoupon'
    },
    {
        path: '/coupons', 
        component: Coupons, 
        name: 'coupons'
    },
    {
        path: '/orders', 
        component: Orders, 
        name: 'orders',
        meta: {
            auth: true
        },
    },
    {
        path: '/products', 
        component: Products, 
        name: 'products'
    },
]

const router = new VueRouter({ mode: 'history', routes })

//if user is not logged in, redirect to login 
router.beforeEach((to, from, next) => {
    const loggedIn = Functions.getCookie('user');
    
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/');
        return
    }
    next();
});

new Vue(Vue.util.extend({ router }, App)).$mount('#app');
