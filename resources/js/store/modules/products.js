const state = {};

const getters = {};

const mutations = {};

const actions = {
    async get_all_products() {
        return await axios.get('/api/v1/all-products');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}