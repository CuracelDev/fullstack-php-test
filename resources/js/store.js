export default {
    state: {
        coupon: ""
    },
    mutations: {
        setCoupon(state, payload) {
            state.coupon = payload;
        }
    }
};
