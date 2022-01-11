
const state = {
    token: null,
    user: {},
};

const getters = {
    user(state) {
        return state.user;
    },
    token(state) {
        return state.token;
    }
};

const mutations = {
    user(state, data) {
        state.token = data.token;
        state.user = data.user;
    },
    logout(state) {
        state.token = null;
        state.user = {};
    }
};

const actions = {
    async login_user({ commit }, payload) {
        const response = await axios.post('/api/v1/login', payload);
        commit('user', response.data.data);

        return response;
    },

    logout_user({commit}) {
        commit('logout')
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}