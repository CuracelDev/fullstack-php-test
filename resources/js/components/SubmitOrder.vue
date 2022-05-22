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
                            <order-item v-for="(i, index) in totalItems" :key="index" @update-total="updateTotal" @remove-total="removeTotal" :total="totalValue"> </order-item>

                            <tr>
                                <td> 
                                    <button @click.prevent="addItem" class=" form-control btn btn-default"> + </button>
                                </td>
                                <td></td>
                                <td><label for="total" > Total </label></td>
                                <td> 
                                    <div class=" form-group form-horizontal">
                                        <input type="text" disabled name="" v-model="totalValue" />
                                    </div>
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
            this.$on('update-total', (data) => {
                console.log(data);
            })
        },

        mounted() {
            this.$on('update-total', (data) => {
                console.log(data);
            })
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
                totalValue2: 0,
                submitButton: 'Submit Order',
                payload: []
            };
        },

        methods: {

            addItem() {
                this.totalItems = this.totalItems + 1
            },

            updateTotal(payload) {
                const itExists = obj => obj.reference == payload.reference;
                const hasIt =  this.payload.some(itExists)
                if (!hasIt) {
                    this.payload.push({...payload})
                } else{
                    this.payload.map((el) => {
                        if (el.reference == payload.reference) {
                            el.value = payload.value
                        }
                    })
                }
            },

            removeTotal(payload) {
                this.payload.pop({...payload})
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

        computed: {
            totalValue() {
                //return this.payload.forEach( el => el.reduce(el.value))
                return this.payload.reduce(function (acc, obj) { return acc + obj.value; }, 0);
            }
        }
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
