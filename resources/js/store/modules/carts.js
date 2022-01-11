import Toasts from "../../utils/toast";

const toast = new Toasts();

const state = {
    cart: [],
};

const getters = {
    cart(state) {
        return state.cart;
    }
};

const mutations = {
    addToCart(state, item) {
        let carts = state.cart;
        let product = carts.find(x => x.id === item.id);
        if (product) {
            product = item;
            toast.showMessage('Item already added', 'error');
        } else {
            carts.push(item);
            toast.showMessage('Item added to cart', 'success');
        }
    },

    clearCart(state) {
        state.cart = [];
    }
};

const actions = {
    add_to_cart({commit}, item) {
        commit('addToCart', item)
    },

    clear_cart({commit}) {
        commit('clearCart');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}