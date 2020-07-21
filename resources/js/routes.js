import VueRouter from "vue-router";
import Products from "./products/Products";

const routes = [
    {
        path: "/",
        component: Products,
        name: "home"
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
