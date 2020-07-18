<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'products'}" class="btn btn-success">Place new order</router-link>
        </div>
        <div class="panel panel-default">
            <h2>All Orders</h2>
            
            <p v-if="ordersError" align="center" style="color:red"> Orders not loaded. Ensure you are logged in </p>
            
            <p v-if="!ordersLoaded" align="center"> Please wait ... </p>

            <div v-else class="panel-body">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Product</th>
                        <th>Coupon code</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orders" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ order.product_name }}</td>
                        <td v-if="order.coupon_code!= ''">{{ order.coupon_code }}</td>
                        <td v-else>None</td>
                        <td>&#8358;{{parseFloat(order.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td> Sub Total </td>
                        <td><b>&#8358; {{ sub_total_price }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td> VAT </td>
                        <td><b>&#8358; {{ vat }}</b> </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td> TOTAL </td>
                        <td><b>&#8358; {{ total_price }}</b> </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>

    import Functions from '@/components/functions';

    export default {
        data: function () {
            return {
                orders: [],
                sub_total_price: '',
                vat: '',
                total_price: '',
                ordersLoaded: false,
                ordersError: false,
            }
        },
        mounted() {
            axios({
                method: 'get',
                url: '/api/v1/orders',
                headers : {
                    'Content-Type': 'application/json',
                    'x-access-token' : Functions.getCookie('user')
                }
            })  
            .then( async (response) => {
                const details = await response.data.data[0];
                this.orders = details.orders;
                this.sub_total_price = Functions.formatPrice(details.sub_total_price);
                this.vat = Functions.formatPrice(details.vat);
                this.total_price = Functions.formatPrice(details.total_price);
                this.ordersLoaded = true;
            })
            .catch( (error) => {
                this.ordersError = true;
            });
        }
    }
</script>
