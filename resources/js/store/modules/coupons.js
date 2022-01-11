
const state = {
    coupons: [],
};

const getters = {
    coupons(state) {
        return state.coupons;
    }
};

const mutations = {
    coupons(state, data) {
        state.coupons = data;
    }
};

const actions = {
    async create_coupon(_, payload) {
        return await axios.post('/api/v1/create-coupon', payload);
    },

    async get_all_coupons({commit}) {
        const response = await axios.get('/api/v1/all-coupons');
        commit('coupons', response.data.data);

        return response;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}