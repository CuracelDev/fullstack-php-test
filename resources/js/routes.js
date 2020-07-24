import VueRouter from "vue-router";
import Products from "./products/Products";
import Product from "./product/Product";
import Coupons from "./coupons/Coupons";
import AddCoupon from "./coupons/AddCoupon";
import Login from "./auth/Login.vue";

const routes = [
    {
        path: "/",
        component: Products,
        name: "home"
    },
    {
        path: "/product/:id",
        component: Product,
        name: "product"
    },
    {
        path: "/coupons",
        component: Coupons,
        name: "coupons"
    },
    {
        path: "/coupon/add",
        component: AddCoupon,
        name: "addCoupon"
    },
    {
        path: "/auth/login",
        component: Login,
        name: "Login"
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
