<template>
  <div>
    <v-row class="pa-4">
      <v-col cols="12" md="8">
        <v-card elevation="2">
          <v-toolbar flat>
            <v-card-title class="px-0">Cart Items</v-card-title>
          </v-toolbar>
          <v-data-table
            :headers="cartHeader"
            :items="cart"
            :hide-default-footer="true"
            item-key="id"
          >
            <template v-slot:[`item.number`]="{ index }">
              <div>{{ index + 1 }}</div>
            </template>
            <template v-slot:[`item.amount`]="{ item }">
              <div>&#8358;{{ item.amount | formatAmount }}</div>
            </template>
            <template v-slot:[`item.discount`]="{ item }">
              <div>&#8358;{{ (item.discount) ? item.discount : '0' | formatAmount }}</div>
            </template>
            <template v-slot:[`item.img_url`]="{ item }">
              <v-img :src="item.img_url" width="30" height="30"></v-img>
            </template>
          </v-data-table>
        </v-card>
      </v-col>

      <v-col>
        <v-card elevation="2">
          <v-toolbar flat>
            <v-card-title class="px-0">Cart Summary</v-card-title>
            <v-row justify="end">
              <v-btn
                small
                outlined
                color="error"
                class="mr-lg-3"
                @click="clearCart()"
              >Clear Cart</v-btn>
            </v-row>
          </v-toolbar>

          <v-form ref="form" class="px-4">
            <v-text-field
              outlined
              dense
              v-model="form.coupons"
              placeholder="Enter coupon if any"
              class="mb-n2"
            ></v-text-field>
            <v-btn
              color="primary"
              @click="applyCoupon"
              :loading="btnLoading"
            >Apply</v-btn>
          </v-form>

          <v-card-title class="pb-0">SubTotal: &#8358;{{ subTotal | formatAmount }}</v-card-title>
          <v-card-title class="py-0">Tax: {{ user.tax_percentage }}%</v-card-title>
          <v-card-title class="py-0">Total: &#8358;{{ total | formatAmount }}</v-card-title>

          <v-card-actions>
            <v-btn
              block
              outlined
              color="primary"
              @click="placeOrder()"
              :loading="loading"
            >Place Order</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import Toasts from "../utils/toast";
    export default {
        name: "Cart",

        data() {
            return {
                cartHeader: [
                    {text: '#', value: 'number', sortable: false, orderable: false},
                    {text: 'Name', value: 'name'},
                    {text: 'Amount', value: 'amount'},
                    {text: 'Discount', value: 'discount'},
                    {text: 'Image', value: 'img_url'}
                ],
                form: {
                    coupons: '',
                    coupon_discount: 0,
                    discount_amount: 0,
                    used_coupon: [],
                    prev_total: 0,
                    products: [],
                },
                toast: new Toasts(),
                cart_amount: [],
                btnLoading: false,
                loading: false,
            }
        },

        created() {
            this.cartAmount();
            this.form.products = this.cart;
            this.$root.$on('clear-discount', () => {
                this.clearDiscount();
            });
        },

        methods: {
            ...mapActions('orders', ['place_order']),
            ...mapActions('cart', ['clear_cart']),

            applyCoupon() {
                this.btnLoading = true;
                setTimeout(() => {
                    this.btnLoading = false;
                }, 1000);
                let coupon = this.coupons.find(x => x.code === this.form.coupons);
                if (typeof coupon === 'undefined') {
                    this.toast.showMessage('Coupon not found or has expired', 'error');
                } else if (!this.checkUserCoupon(coupon)) {
                    this.toast.showMessage('Coupon not valid for your account', 'error');
                } else if (!this.checkProductCoupon(coupon)) {
                    this.toast.showMessage('Coupon not found for any product in your cart', 'error')
                } else {
                    if (this.form.used_coupon.find(x => x === coupon.code)) {
                        this.toast.showMessage('Coupon already applied', 'error');
                    } else {
                        if (!this.form.used_coupon.find(x => x === coupon.code)) {
                            this.form.used_coupon.push(coupon.code);
                        }
                        return this.total;
                    }
                }
            },

            clearCart() {
                this.clear_cart();
                this.toast.showMessage('cart cleared', 'success');
            },

            async placeOrder() {
                this.loading = true;
                try {
                    const response = await this.place_order(this.form);
                    this.toast.successMessage(response);
                    this.loading = false;
                } catch (error) {
                    this.toast.errorMessage(error);
                    this.loading = false;
                }
            },

            checkUserCoupon(coupon) {
                return coupon.user_id === this.user.id;
            },

            checkProductCoupon(coupon) {
                this.btnLoading = true;
                let carts = this.cart;
                let products = carts.filter(item1 => coupon.products.find(item2 =>
                    item1.id === item2.id));
                if (products) {
                    for (let i = 0; i < products.length; i++) {
                        let coupon_percentage = coupon.discount_percentage;
                        this.form.coupon_discount += coupon_percentage / 100 * products[i].amount;
                        let item = carts.find(x => x.id === carts[i].id);
                        if (item) {
                            item['discount'] = coupon_percentage / 100 * products[i].amount;
                        }
                        this.cartAmount(products[i], this.form.coupon_discount);
                    }
                    this.form.discount_amount = this.form.coupon_discount;
                    setTimeout(() => {
                        this.form.coupon_discount = 0;
                    }, 1000);
                    return true;
                }
                return false;
            },

            cartAmount(product, discount) {
                let amount = 0;
                let cart = this.cart;
                for (let i = 0; i < cart.length; i++) {
                    amount += (product && cart[i].amount === product.amount) ? discount : cart[i].amount;
                }
                return amount;
            },

            clearDiscount() {
                this.form = {};
                let cart = this.cart;
                for (let i = 0; i < cart.length; i++) {
                    if (cart[i].discount) {
                        delete cart[i].discount;
                    }
                }
            }
        },

        computed: {
            ...mapGetters('cart', ['cart']),
            ...mapGetters('auth', ['user']),
            ...mapGetters('coupons', ['coupons']),

            subTotal() {
                return this.cartAmount();
            },

            total() {
                let subTotal = this.cartAmount();
                let tax = this.user.tax_percentage / 100;
                let taxed_amount = subTotal * tax;
                let total = subTotal + taxed_amount - this.form.discount_amount;
                this.form.amount = total;
                return total;
            },
        }
    }
</script>

<style scoped>

</style>