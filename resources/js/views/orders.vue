<template>
  <div class="m-4">
    <v-row>
      <v-col>
        <v-toolbar flat>
          <v-card-title class="px-0">Orders</v-card-title>
        </v-toolbar>
        <v-data-table
          :headers="orderHeader"
          :items="orders"
          item-key="id"
          :search="search"
          :loading="loading"
          :items-per-page="10"
        >
          <template v-slot:[`item.number`]="{ index }">
            <div>{{ index + 1 }}</div>
          </template>
          <template v-slot:[`item.amount`]="{ item }">
            <div>&#8358;{{ item.amount | formatAmount }}</div>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import Toasts from "../utils/toast";
    export default {
        name: "orders",
        data() {
            return {
                loading: false,
                search: '',
                orderHeader: [
                    {text: '#', value: 'number', orderable: false, sortable: false},
                    {text: 'User', value: 'user.email'},
                    {text: 'Name', value: 'product.name'},
                    {text: 'Amount', value: 'amount'},
                ],
                orders: [],
                toast: new Toasts(),
            }
        },

        created() {
            this.getOrders();
        },

        methods: {
            ...mapActions('orders', [
                'get_all_orders'
            ]),

            async getOrders() {
                this.loading = true;
                try {
                    const response = await this.get_all_orders();
                    this.orders = response.data.data;
                    this.loading = false;
                } catch (error) {
                    this.loading = false;
                    this.toast.errorMessage(error);
                }
            }
        },
    }
</script>

<style scoped>

</style>