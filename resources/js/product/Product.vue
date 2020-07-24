<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div class="row" v-else>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>
                            {{ product.name }} -
                            <span>&#8358;{{ product.price }}</span>
                        </h1>

                        <hr />
                        <article>{{ product.details }}</article>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pb-4">
                <product-price
                    v-bind="product"
                    v-on:showCoupon="getCoupon"
                    @validCoupon="checkPrice($event)"
                ></product-price>

                <transition name="fade">
                    <price-breakdown
                        :final_price="final_price"
                        :price="price"
                    ></price-breakdown>
                </transition>

                <transition name="fade">
                    <button class="mt-1 btn btn-outline-secondary btn-block">
                        Buy Now
                    </button>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import ProductPrice from "./ProductPrice";
import PriceBreakdown from "./PriceBreakdown";
export default {
    components: {
        ProductPrice,
        PriceBreakdown
    },
    data() {
        return {
            coupon: "",
            product: null,
            loading: false,
            price: null,
            final_price: null
            // initial_price: null,
            // discounted_price: null,
            // tax: null,
            // total_price: null
        };
    },
    created() {
        this.loading = true;
        axios.get(`/api/products/${this.$route.params.id}`).then(res => {
            console.log(res);
            this.product = res.data.data;
            this.final_price = res.data.data.price;
            this.loading = false;
        });
    },
    methods: {
        getCoupon(value) {
            this.coupon = value;
        },
        async checkPrice(validCoupon) {
            try {
                this.price = (
                    await axios.get(
                        `/api/products/${this.product.id}/price?coupon=${this.coupon}`
                    )
                ).data;
            } catch (err) {
                console.log(err);
            }
        }
    }
};
</script>
