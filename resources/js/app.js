require("./bootstrap");

import Vue from "vue";
import Vuex from "vuex";
import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index.vue";
import storeDefinition from "./store";

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeDefinition);

window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response.status === 401) {
            store.dispatch("logout");
        }

        return Promise.reject(error);
    }
);

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        Index: Index
    },
    async beforeCreate() {
        this.$store.dispatch("loadUser");
    }
});
