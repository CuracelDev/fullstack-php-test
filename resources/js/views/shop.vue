<template>
  <div class="ma-0 pa-0">
    <v-toolbar flat class="px-0 ma-0">
      <v-card-title class="px-0">Products</v-card-title>
    </v-toolbar>
    <v-row class="pa-4">
      <v-col cols="6" md="3" v-for="(product) in products" :key="product.id">
        <a href="javascript:void(0)" @click="addToCart(product)">
          <v-card max-height="250">
            <v-img :src="product.img_url" height="150"></v-img>
            <v-card-subtitle class="py-0 px-2">{{ product.name }}</v-card-subtitle>
            <div class="d-flex justify-content-between">
              <small class="px-2 py-0 text-decoration-line-through">&#8358;{{ product.old_amount | formatAmount }}</small>
              <small class="px-2">&#8358;{{ product.amount | formatAmount }}</small>
            </div>
          </v-card>
        </a>
      </v-col>
    </v-row>
      <add-to-cart :add-to-cart-dialog="cartDialog" :item="item"></add-to-cart>
      <authenticate :auth-dialog="authDialog"></authenticate>
  </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import Toasts from '../utils/toast';
    import AddToCart from '../components/AddToCart';
    import Authenticate from "../components/Authenticate";
    export default {
        components: {
            AddToCart,
            Authenticate,
        },

        name: "shop",

        data() {
            return {
                dialog: false,
                products: [],
                toast: new Toasts(),
                authDialog: false,
                cartDialog: false,
                item: {},
            }
        },

        created() {
            this.getProducts();
        },

        methods: {
            ...mapActions('products', [
                'get_all_products'
            ]),

            async getProducts() {
                try {
                    const response = await this.get_all_products();
                    this.products = response.data.data;
                } catch (error) {
                    this.toast.errorMessage(error);
                }
            },

            openAuthDialog() {
                this.authDialog = true;
            },

            openCartDialog() {
                this.cartDialog = true;
            },

            addToCart(product) {
                if (this.token) {
                    this.item = product;
                    this.openCartDialog();
                } else {
                    this.openAuthDialog();
                }
            }
        },

        computed: {
            ...mapGetters('auth', ['token', 'user'])
        }
    }
</script>

<style scoped>

</style>