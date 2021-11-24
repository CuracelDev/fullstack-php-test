<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <h3>Create Order</h3>
                        <div class="alert alert-danger" v-if="error">{{error}}</div>
                        <div class="alert alert-success" v-if="statusText">{{statusText}}</div>
                        
                        <div class="form-group">
                            <label for="provider">Provider</label>
                            <input type="text" class="form-control" v-model="provider" id="provider">
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

                        <table class="order-table mb-3">
                            <thead>
                                <tr>
                                    <th class="item">Item</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in orderItems" :key="index">
                                    <td class="form-group">
                                        <input class="form-control" type="text" v-model="item.item" id="item">
                                    </td>
                                    <td class="form-group">
                                        <input class="form-control" type="number" v-model="item.unitPrice" step="0.01" min="0" id="unitPrice">
                                    </td>
                                    <td class=" form-group">
                                        <input class="form-control" type="number" v-model="item.quantity" min="0" id="quantity">
                                    </td>
                                    <td class="form-group">
                                        <input class="form-control" type="text" v-model="item.totalPrice" id="subtotal" readonly>
                                    </td>
                                    <td class="form-group">
                                        <button class="btn btn-danger" @click.prevent="removeItem(index)"><span>x</span></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button class="btn btn-success" @click.prevent="addItem"><span>+</span></button>
                                    </td>
                                    <td class="text-right"><label for="total">Total</label></td>
                                    <td colspan="2">
                                        <input class="form-control" type="text" v-model="totalPrice" id="total" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-secondary" @click="submitOrder" :disabled="isSaving">{{isSaving ? 'Submit...' : 'Submit'}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {

        data: () => ({
            orderItems : [{
                item: '',
                unitPrice: 0.00,
                quantity: 0,
                totalPrice: 0.00
            }],

            hmoCode: '',
            provider: '',
            encounterDate: '',

            error: '',
            statusText: '',

            isSaving: false,
        }),

        methods: {
            addItem() {
                this.orderItems.push({
                    item: '',
                    unitPrice: 0,
                    quantity: 0,
                    totalPrice: 0.00
                });
            },

            removeItem(index) {
                //prevent component from removing all items
                if (this.orderItems.length > 1) {
                    this.orderItems.splice(index, 1);
                }else {
                    this.orderItems[0].item = '';
                    this.orderItems[0].unitPrice = 0.00;
                    this.orderItems[0].quantity = 0;
                    this.orderItems[0].totalPrice = 0.00;
                }
            },

            submitOrder() {
                
                //clear error message
                this.error = '';
                this.statusText = '';

                this.isSaving = true;

                //submit order to server
                axios.post('/api/orders', {
                    hmoCode: this.hmoCode,
                    provider: this.provider,
                    orderItems: this.orderItems,
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
                    this.isSaving = false;
                });
            }   
        },

        computed: {
            totalPrice() {
                return this.orderItems.reduce((total, item) => {
                    return total + item.totalPrice;
                }, 0);
            }
        },

        watch: {
            orderItems: {
                handler() {
                    this.orderItems.forEach(item => {
                        item.totalPrice = item.unitPrice * item.quantity;
                    });
                }, 
                deep: true
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
.item{
    width: 40%;
}

.order-table td,
.order-table th {
    padding: .5rem;
}

.order-table td:first-child,
.order-table th:first-child {
    padding-left: 0rem;
}

.order-table td:last-child,
.order-table th:last-child {
    padding-right: 0rem;
}
</style>
