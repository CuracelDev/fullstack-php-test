<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h3>Order Form</h3></div>

                    <div  class="alert alert-danger" role="alert" v-show="showErrorMessage">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><b>&times;</b></span>
                        </button> -->
                        <div v-for="(er, key) in error">
                            <span class="error-label">{{ error[key] }}</span>
                        </div>
                    </div>

                    
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-show="showSuccessMessage">
                        <button type="button" onClick="window.location.reload()" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><b>&times;</b></span>
                        </button>
                        <span>Order submitted successfully!</span>
                    </div>
                    

                    <!-- <div class="alert alert-danger" role="alert" v-show="showErrorMessage">
                        <strong>Error!</strong> {{ errorMessage }}
                    </div> -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm">
                                Provider Name
                                <input type="text" v-model="order.provider_name" class="form-control">
                            </div>
                            <div class="col-sm">
                                HMO Code
                                <select v-model="order.hmo_code" class="custom-select" >
                                    <!-- <option disabled selected>Choose...</option> -->
                                    <option v-for="(hmo, index) in hmos" :key="index" :value="hmo.code">{{ hmo.code }}</option>
                                </select>
                                <!-- <input type="text" v-model="order.hmo_code" class="form-control"> -->
                            </div>
                            <div class="col-sm">
                                Encounter Date
                                <input type="date" v-model="order.encounter_date" class="form-control">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3">
                                Item
                            </div>
                            <div class="col-sm-2">
                                Unit Price
                            </div>
                            <div class="col-sm-2">
                                Qty
                            </div>
                            <div class="col-sm-2">
                                Sub Total
                            </div>
                            <div class="col-sm-2"></div>
                        </div>

                        <div class="row" v-for="(item,i) in order.items" :key="i">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3">
                                <input type="text" v-model="item.item" class="form-control" :id="'item'+i" >
                            </div>
                            <div class="col-sm-2">
                                <input type="number" min="1" v-model="item.unit_price" class="form-control" :id="'unit-price'+i" >
                            </div>
                            <div class="col-sm-2">
                                <input type="number" min="1" v-model="item.quantity" class="form-control" :id="'quantity'+i" >
                            </div>
                            <div class="col-sm-2">
                                <input type="text" readonly :value="calculateSubTotal(item)" class="form-control" :id="'sub-total'+i">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-danger btn-md" @click="removeItem(i)" :id="'remove-button'+i"> - </button>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-md" @click="addItem()" id="add-button"> + </button>
                            </div>
                            <div class="col-md-9"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-7"></div>
                            <div class="col-md-1">
                                <b>Total</b>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="total" readonly class="form-control" v-model="calculateTotal" >
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-1"></div>
                            <div class="col-6">
                                <button @click="submit()" 
                                :disabled="isSubmitting"
                                class="btn btn-info btn-md submit">{{ isSubmitting ? 'Please wait..' : 'Submit' }}
                            </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                hmos: [],
                order: {
                    provider_name:'',
                    hmo_code:'',
                    encounter_date: '',
                    items:[
                        {
                            item:'',
                            unit_price: 0,
                            quantity: 0
                        }
                    ]
                },
                isSubmitting : false,
                showSuccessMessage: false,
                showErrorMessage: false,
                error:[],
            }
        },

        methods:{
            addItem() {
                this.order.items.push({
                    item:'',
                    unit_price: 0,
                    quantity: 0
                });
            },

            removeItem(i) {
                this.order.items.splice(i,1);
            },

            calculateSubTotal(item) {
                if (item.unit_price && item.quantity) {
                    let sub_total = item.unit_price * item.quantity;
                    return sub_total;
                } 
                return 0;
            },

            inputValidation(){
                let errorExist = false;

                if(this.order.provider_name.trim().length < 1){
                    this.error.push("Provider Name required");
                    errorExist = true;
                }
                if(this.order.hmo_code.trim().length < 1){
                    this.error.push("HMO Code required");
                    errorExist = true;
                }
                if(!this.order.encounter_date){
                    this.error.push("Encouter date required");
                    errorExist = true;
                }
                if (this.order.items.length < 1){
                    this.error.push("Order items required");
                    errorExist = true;
                }

                return errorExist;
            },

            getHmoCodes() {
                this.error = [];
                this.showErrorMessage = false,

                axios.get('/api/hmos')
                .then(response => {
                    this.hmos = response.data.data;
                }).catch(error => {
                    if(error.response.data.message){
                        this.error.push(error.response.data.message);
                    }
                    else{
                        this.error.push("An error occurred");
                    }
                }).finally(() => {
                    this.isSubmitting = false;
                })
            },

            submit() {

                this.error = [];
                this.showErrorMessage = false,
                this.isSubmitting = true;

                if(this.inputValidation()){
                    this.showErrorMessage = true;
                    this.isSubmitting = false;
                    return;
                }

                axios.post('/api/orders', this.order)
                .then(response => {
                    this.showSuccessMessage = true;
                }).catch(error => {
                    this.showErrorMessage = true;

                    if(error.response.status == 422){
                        let result = [];

                        for (const x in error.response.data.errors){
                            result.push(error.response.data.errors[x]);
                        }

                        this.error = result;
                    }
                    else if(error.response.data.message){
                        this.error.push(error.response.data.message);
                    }
                    else{
                        this.error.push("An error occurred");
                    }
                }).finally(() => {
                    this.isSubmitting = false;
                })
            },
        },

        computed:{
            calculateTotal: function() {
                return this.order.items.reduce((sum, item) => {
                    let quantity = item.quantity || 0;
                    let price = item.unit_price || 0;
                    return sum + (quantity * price);
                }, 0)
            }
        },

        mounted() {
            console.log('Component mounted.')
            this.getHmoCodes();
        }
    }
</script>

<style>
.row{
    margin: 10px 0px;
}
</style>
