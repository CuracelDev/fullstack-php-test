import VueRouter from "vue-router";
import Products from "./products/Products";
import Product from "./product/Product";

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
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
