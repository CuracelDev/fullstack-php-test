<template>
  <div class="m-4">
    <v-row>
      <v-col>
        <v-toolbar flat>
          <v-card-title class="px-0">Products</v-card-title>
        </v-toolbar>
        <v-data-table
          :headers="productHeader"
          :items="products"
          item-key="id"
          :search="search"
          :items-per-page="10"
          :loading="loading"
        >
          <template v-slot:[`item.number`]="{ index }">
            <div>{{ index + 1 }}</div>
          </template>
          <template v-slot:[`item.amount`]="{ item }">
            <div>&#8358;{{ item.amount | formatAmount }}</div>
          </template>
          <template v-slot:[`item.in_stock`]="{ item }">
            <div>{{ (item.quantity > 0) ? 'Yes' : 'No' }}</div>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        name: "dashboard",
        data() {
            return {
                loading: false,
                search: '',
                productHeader: [
                    {text: '#', value: 'number', orderable: false, sortable: false},
                    {text: 'Name', value: 'name'},
                    {text: 'Amount', value: 'amount'},
                    {text: 'Coupon', value: 'coupon.code'},
                    {text: 'Quantity', value: 'quantity'},
                    {text: 'In Stock', value: 'in_stock'},
                    {text: 'Age Limit', value: 'age_limit'},
                ],
                products: [],
                orders: [],
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
                this.loading = true;
                try {
                    const response = await this.get_all_products();
                    this.products = response.data.data;
                    this.loading = false;
                } catch (error) {
                    this.loading = false;
                    this.toast.errorMessage(error);
                }
            }
        }
    }
</script>

<style scoped>

</style>