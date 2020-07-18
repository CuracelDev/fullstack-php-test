require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import App from "./App.vue";
import Login from './components/users/Login.vue';
import Register from './components/users/Register.vue';
import AddCoupon from './components/coupons/AddCoupon.vue';
import Coupons from './components/coupons/Coupons.vue';
import Products from './components/products/Products.vue';
import Orders from './components/orders/Orders.vue';

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
        name: 'orders'
    },
    {
        path: '/products', 
        component: Products, 
        name: 'products'
    },
]

const router = new VueRouter({ mode: 'history', routes });
new Vue(Vue.util.extend({ router }, App)).$mount('#app');
