<template>
  <div>
    <v-dialog
      max-width="450"
      v-model="addToCartDialog"
      persistent
    >
      <v-card>
        <v-toolbar flat color="primary">
          <v-card-title class="text-center text-white">Product Details</v-card-title>
        </v-toolbar>

        <v-card-text class="py-0">Name: {{ item.name }}</v-card-text>
        <v-card-text class="py-0">Amount: &#8358;{{ item.amount }}</v-card-text>
        <v-card-actions
          class="d-flex justify-content-end"
        >
          <v-btn
            outlined
            color="error"
            @click="closeDialog"
          >Close</v-btn>
          <v-btn
            color="primary"
            @click="addCart"
          >Add To Cart</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        props: {
            addToCartDialog: {
                Boolean,
                default: false,
            },
            item: {},
        },

        name: "AddToCart",

        data() {
            return {

            }
        },

        methods: {
            ...mapActions('cart', ['add_to_cart']),

            closeDialog() {
                this.$parent.cartDialog = false;
            },

            addCart() {
                this.add_to_cart(this.item);
                this.closeDialog();
            },
        }
    }
</script>

<style scoped>

</style>