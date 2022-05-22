<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="alert alert-danger alert-dismissible" v-if="error" >
                    <a href="#" class="close" data-dismiss="alert"
                        aria-label="close">&times;</a>
                    {{error}}  </div>
                    <div class="card-header">Submit An Order</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Item </th>
                                <th>Unit Price </th>
                                <th>Qty </th>
                                <th>Sub Total </th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <order-item v-for="(i, index) in totalItems" :key="index"> </order-item>

                            <tr>
                                <td> 
                                    <button @click.prevent="addItem" class=" form-control btn btn-default"> + </button>
                                </td>
                                <td> 
                                    <label for="total" > Total</label>
                                    <input type="text" name="" />
                                </td>
                            </tr>

                        </tbody>


                    </table>

                    <hr>

                    <div class="card-body">
                        <strong> Order details here </strong>

                        <div class="form-group">
                            <label for="provider">Provider</label>
                            <input type="text" class="form-control" v-model="provider" id="provider" autofocus>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="hmo">Hmo Code</label>
                                    <input type="text" class="form-control" v-model="hmoCode" id="hmo">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="encounterDate">Encounter Date</label>
                                    <input type="date" class="form-control" v-model="encounterDate" id="encounterDate">
                                </div>
                            </div>
                        </div>


                    </div>

                    <button type="submit" class="" @click.prevent="submitOrder"> 
                        <span>{{submitButton}}</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import OrderItem from './OrderItem.vue';
    export default {
        components: {
            OrderItem
        },

        async created() {

        },

        data() {
            return {
                totalItems: 4,
                orderItems:[],
                error: '',
                errors: [],
                saving: false,
                encounterDate: '',
                provider: '',
                hmoCode: '',
                submitButton: 'Submit Order'
            };
        },

        methods: {

            addItem() {
                this.totalItems = this.totalItems + 1
            },

            submitOrder() {
                this.submitButton = 'Saving...'
                axios.post('/api/orders/save', {
                    hmoCode: this.hmoCode,
                    provider: this.provider,
                    orderItems: this.orderItems,
                    subTotal: this.subTotal,
                    totalPrice: this.totalPrice,
                    encounterDate: this.encounterDate
                }).then(response => {
                    this.statusText = "Saved!";
                    setTimeout(() => {
                        this.statusText = '';
                    }, 3000);
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.error = Object.values(error.response.data.errors)[0][0];
                    }else {
                        this.error = error.response.data.message;
                    }
                }).finally(() => {
                    this.submitButton = 'Submit Order'
                });
            }

        },
    };
</script>

<style scoped>
    table {
        margin: 10px
    }

    .btn-default {
        border: solid 1px #ccc;
    }
</style>
