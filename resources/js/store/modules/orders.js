
const state = {};

const getters = {};

const mutations = {};

const actions = {
    async get_all_orders() {
        return await axios.get('/api/v1/all-orders');
    },

    async place_order(_, payload) {
        return await axios.post('/api/v1/place-order', payload);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}