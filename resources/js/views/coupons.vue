<template>
  <div class="m-4">
    <v-row>
      <v-col>
        <v-toolbar flat>
          <v-card-title class="px-0">Coupons</v-card-title>
          <v-row justify="end">
            <v-btn small color="primary" @click="openModal()">
              <v-icon size="17">mdi-plus</v-icon>
              New Coupon
            </v-btn>
          </v-row>
        </v-toolbar>
        <v-data-table
          :headers="couponHeader"
          :items="coupons"
          item-key="id"
          :search="search"
          :items-per-page="10"
          :loading="loading"
        >
          <template v-slot:[`item.number`]="{ index }">
            <div>{{ index + 1 }}</div>
          </template>
        </v-data-table>
      </v-col>
    </v-row>

    <coupon-dialog :dialog="dialog"></coupon-dialog>
  </div>
</template>

<script>
    import CouponDialog from '../components/CreateCoupon';
    import { mapActions } from 'vuex';
    import Toasts from '../utils/toast';
    export default {
        components: {
            CouponDialog,
        },

        name: "coupons",

        data() {
            return {
                loading: false,
                search: '',
                couponHeader: [
                    {text: '#', value: 'number', orderable: false, sortable: false},
                    {text: 'Code', value: 'code'},
                    {text: 'User', value: 'user.email'},
                    {text: 'Products', value: 'products.length'},
                    {text: 'Discount Percentage (%)', value: 'discount_percentage'},
                ],
                coupons: [],
                dialog: false,
                total_coupons: 0,
                total_coupons_amount: 0,
                used_coupons: 0,
                used_coupons_amount: 0,
                unused_coupons: 0,
                unused_coupons_amount: 0,
                toast: new Toasts(),
            }
        },

        created() {
            this.getCoupons();
        },

        methods: {
            ...mapActions('coupons', [
                'get_all_coupons',
            ]),

            openModal() {
                this.dialog = true;
            },

            async getCoupons() {
                this.loading = true;
                try {
                    const response = await this.get_all_coupons();
                    this.coupons = response.data.data;
                    this.loading = false;
                } catch (error) {
                    this.toast.errorMessage(error);
                    this.loading = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>