<template>
    <div class="container">
        <notifications/>

        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        
                        <form @submit.prevent="submit">
                            <div class="form-group col-md-6 ml--15">
                                <label for="providerName">Provider Name</label>
                                <input v-model="providerName" type="text" class="form-control" id="providerName" placeholder="Provider Name" required>
                            </div>
                            <div class="form-group col-md-4 ml--15">
                                <label for="hmo">HMO Code</label>
                                <select v-model="hmoCode" name="hmoCode" id="hmoCode" class="custom-select" required >
                                    <option disabled selected>Choose...</option>
                                    <option v-for="(hmo, index) in hmoCodes" :key="index" :value="hmo">{{ hmo }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 ml--15">
                                <label for="date">Encounter Date</label>
                                <input v-model="date" type="date" class="form-control" id="date" name="date" required>
                            </div>

                            <div v-for="(order, index) in orders" :key="index" class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label v-if="index==0" for="item">Item</label>
                                    <input :id="'item' + index" :value="order.name" @input="(event) => {order.name = event.target.value}" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="unitPrice">Unit Price</label>
                                    <input :id="'unitPrice' + index" :value="order.unit_price" @input="(event) => {if ( event.target.value > 0 )order.unit_price = event.target.value}" type="number" min="1" class="form-control" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="quantity">Qty</label>
                                    <input :id="'quantity' + index" :value="order.quantity" @input="(event) => {if ( event.target.value > 0 ) order.quantity = event.target.value}" type="number" min="1" class="form-control" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="subTotal">Sub Total</label>
                                    <input :id="'subTotal' + index" :value="order.sub_total" type="text" class="form-control" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label v-if="index==0" for="remove" style="margin-top: 45px; margin-left: -4px;"></label>
                                    <button :id="'remove' + index" class="btn btn-danger" @click="removeItem(index)"> - </button>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-1 mb-3">
                                    <button class="btn btn-primary" id="add" @click="addItem()"> + </button>
                                </div>
                                <div class="col-md-2 mb-3 offset-md-7">
                                    <div class="d-flex align-items-center">
                                        <label >Total</label>
                                        <input id="total" :value="total" type="text" class="form-control ml-3" readonly>
                                    </div>
                                </div>
                            </div>

                            <button :disabled="submitted" class="btn btn-primary" type="submit">Submit Order</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .ml--15 {
        margin-left: -15px !important;
    }
</style>

<script>
    import axios from 'axios';

    export default {
        data() {
         return {
            hmoCodes: [],
            date: "",
            providerName: "",
            hmoCode: "",
            orders: [
                {
                    name: "",
                    unit_price: 0,
                    quantity: 0,
                    sub_total: 0,
                }
            ],
            submitted: false
         };
        },
        mounted() {
            this.getHmoCodes();
        },
        methods: {
            submit() {
                if(this.hmoCode.trim().length < 2){
                    this.notifyError("HMO Code required");
                    return;
                }

                if(this.providerName.trim().length < 2){
                    this.notifyError("Provider Name required");
                    return;
                }

                if(!this.date){
                    this.notifyError("Encouter date required");
                    return;
                }

                if (this.orders.length < 1){
                    this.notifyError("Order details must be filled");
                    return;
                }

                this.orders.forEach(element => {
                    if (
                        element.name.trim().length < 1 || 
                        element.unit_price < 1 ||
                        element.quantity < 1
                    ){
                        this.notifyError("Order details must be filled");
                        return;
                    }
                });

                this.submitted = true;

                const data = {
                    "hmo_code" : this.hmoCode,
                    "provider_name" : this.providerName,
                    "encounter_date" : this.date,
                    "items": this.orders
                }

                axios.post('/api/submit-order', data, {
                    headers: {
                    'Content-Type': 'application/json'
                }})
                    .then(response => {
                        this.notifySuccess(response.data.message);

                        this.hmoCode = "";
                        this.providerName = "";
                        this.date = "";
                        this.orders = [
                            {
                                name: "",
                                unit_price: 0,
                                quantity: 0,
                                sub_total: 0,
                            }
                        ];
                    }).catch(error => {
                        this.notifyError(error.response.data.message ?? "An Error occurred");
                }).finally(() => {
                    this.submitted = false;
                });
            },
            addItem() {
                this.orders.push({
                    name: "",
                    unit_price: 0,
                    quantity: 0,
                    sub_total: 0,
                });
            },
            removeItem(index) {
              if (this.orders.length > 1) {
                this.orders.splice(index, 1)
              }
            },
            getHmoCodes() {
                axios.get('/api/hmos', null, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((response) => {
                    this.hmoCodes = response.data.data;
                }).catch((error) => {
                    console.log('error fetching hmos code', error)
                })
            },
            notifyError(text){
              this.$notify({
                title: "Error",
                text: text ?? "",
                type: 'error',
              });
            },
            notifySuccess(text){
              this.$notify({
                title: "Success",
                text:  text ?? "",
                type: 'success',
              });
            }
        },
        computed: {
            total: {
                get() {
                    return this.orders.reduce((accumulator, currentValue) => {
                        return accumulator + currentValue.sub_total;
                    }, 0);
                },
            }
        },
        watch: {
            orders: {
                handler (modifiedOrder) {
                    modifiedOrder.forEach(order => {
                        if(!isNaN(order.unit_price) && !isNaN(order.quantity)) {
                            order.sub_total = order.unit_price * order.quantity;
                        }
                    });
                },
                deep: true
            },
        },
    }
</script>
