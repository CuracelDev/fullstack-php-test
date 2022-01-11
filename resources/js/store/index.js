import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'

import products from "./modules/products";
import cart from './modules/carts';
import coupons from "./modules/coupons";
import orders from "./modules/orders";
import auth from "./modules/auth";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        products,
        cart,
        coupons,
        orders,
        auth,
    },
    plugins: [
        createPersistedState({
            key: 'Curacel'
        })
    ]
});