require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index.vue";

Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    router,
    components: {
        Index: Index
    }
});
