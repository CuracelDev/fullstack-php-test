<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'addCoupon'}" class="btn btn-success">Add new coupon</router-link>
        </div>
        <div class="panel panel-default">
            <h2>All Coupons</h2>
            
            <p v-if="!couponsLoaded" align="center"> Please wait ... </p>

            <div v-else class="panel-body">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Code</th>
                        <th>Tax</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(coupon, index) in coupons" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ coupon.code }}</td>
                        <td>{{ coupon.tax }}%</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data: function () {
            return {
                coupons: [],
                couponsLoaded: false,
            }
        },
        mounted() {
            axios.get('/api/v1/coupons')
                .then( async (response) => {
                    this.coupons = await response.data.data;
                    this.couponsLoaded = true;
                })
                .catch( (error) => {
                    alert("Could not load coupons. Try again.");
                });
        }
    }
</script>
