<template>
    <div>
        <h5 class="text-uppercase text-secondary font-weight-bolder">
            Total Price
        </h5>
        <div v-if="coupon_needed">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="coupon">Coupon</label>
                    <transition name="fade">
                        <span v-if="couponValid" class="text-success"
                            >(valid)</span
                        >
                        <span v-if="couponInvalid" class="text-danger"
                            >(invalid)</span
                        >
                    </transition>

                    <input
                        type="text"
                        name="coupon"
                        class="form-control"
                        placeholder="Enter Coupon Code"
                        v-model="coupon"
                        @keyup.enter="applyCoupon"
                        :class="[{ 'is-invalid': this.errorCouponField() }]"
                    />
                    <div class="invalid-feedback" v-if="errors">
                        {{ errors }}
                    </div>
                </div>
            </div>

            <button
                class="btn btn-secondary btn-block"
                @click.prevent="applyCoupon"
                :disabled="loading"
            >
                Apply!
            </button>
        </div>
        <div v-else>
            <h2>&#8358;{{ price }}</h2>
        </div>
    </div>
</template>

<script>
export default {
    props: { coupon_needed: Number, price: Number },
    data() {
        return {
            coupon: null,
            loading: false,
            status: null,
            errors: null
        };
    },
    methods: {
        async applyCoupon() {
            this.loading = true;

            try {
                this.status = (
                    await axios.get(
                        `/api/products/${this.$route.params.id}/price?coupon=${this.coupon}`
                    )
                ).status;
                this.$emit("validCoupon", this.couponValid);
                this.$emit("showCoupon", this.coupon);
            } catch (error) {
                if (error.response.status === 400) {
                    this.errors = error.response.data.message;
                }

                this.status = error.response.status;
                this.$emit("validCoupon", this.couponValid);
            }

            this.loading = false;
        },
        errorCouponField() {
            return this.hasErrors;
        }
    },
    computed: {
        hasErrors() {
            return this.status === 400 && this.errors !== null;
        },
        couponValid() {
            return this.status === 200;
        },
        couponInvalid() {
            return this.status === 400;
        }
    }
};
</script>
