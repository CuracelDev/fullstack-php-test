<template>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">Welcome, Kindly Submit your orders here</div>

                    <div class="card-body">

                        <h3 class="text-center">Order Information</h3>

                        <div class="form-group row">
                            <label for="hmo_code" class="col-md-4 col-form-label text-md-right">Hmo Code</label>

                            <div class="col-md-6">
                                <Input
                                    type="text"
                                    v-model="hmoCode"
                                    placeholder="Hmo Code"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provider_name" class="col-md-4 col-form-label text-md-right">Provider Name</label>

                            <div class="col-md-6">
                                <Input
                                    type="text"
                                    v-model="providerName"
                                    placeholder="Provider Name"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="encounter_date" class="col-md-4 col-form-label text-md-right">Encounter Date</label>

                            <div class="col-md-6">
                                <Input
                                    type="date"
                                    v-model="encounterDate"
                                />
                            </div>
                        </div>

                        <h3 class="text-center mt-6">Order Items</h3>

                        <div class="form-group mt-2">
                            <div class="row mb-3">
                                <div class="col">Item</div>
                                <div class="col">Unit Price</div>
                                <div class="col">Quantity</div>
                                <div class="col">Sub Total</div>
                                <div class="col">Action</div>
                            </div>
                            <div v-for="(form, index) in forms" :key="index" class="row mb-3">
                                <div class="col">
                                    <Input
                                        type="text"
                                        v-model="form.item"
                                    />
                                </div>

                                <div class="col">
                                    <Input
                                        type="number"
                                        v-model="form.unit_price"
                                    />
                                </div>

                                <div class="col">
                                    <Input
                                        type="number"
                                        v-model="form.quantity"
                                    />
                                </div>

                                <div class="col">
                                    <Input
                                        type="number"
                                        v-model="form.subTotal"
                                    />
                                </div>

                                <div class="col-auto">
                                    <button @click="removeForm(index)" class="btn btn-danger">-</button>
                                </div>

                            </div>
                        </div>


                        <div class="row justify-content-between mt-3">
                            <div class="col-auto">
                                <button @click="addForm" class="btn btn-success">+</button>
                            </div>
                            <div class="col-auto">
                                <label>Total:</label>
                                <input type="number" :value="total" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" :class="`btn btn-success mt-3 ${disabled ? 'disabled' : ''}`" @click="submitOrder">
                                {{ loading ? 'Submitting Order..'  : 'Submit Order' }}
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script>

import axios from 'axios';
import Input from "./ui/Input.vue";

export default {
    name:"Submit-Order",
    components:{Input},
    data() {
        return {
            forms: [
                { item: '', unit_price: 0, quantity: 0, subTotal: 0 },
                { item: '', unit_price: 0, quantity: 0, subTotal: 0 }
            ],
            encounterDate:"",
            providerName:"",
            hmoCode:"",
            loading:false,
        };
    },
    computed: {
        total() {
            return this.forms.reduce((acc, form) => acc + form.subTotal, 0);
        },
        disabled(){
            return this.loading || this.encounterDate === '' || this.hmoCode === '' || this.providerName === ''  ||  !this.forms.some(form => form.item && form.unitPrice !== 0 && form.quantity !== 0);
        }
    },
    methods: {
        addForm() {
            this.forms.push({ item: '', unit_price: 0, quantity: 0, subTotal: 0 });
        },
        removeForm(index) {
            this.forms.splice(index, 1);
        },
        calculateSubTotal(form) {
            form.subTotal = form.unit_price * form.quantity;
        },
        submitOrder() {
            const orderData = {
                hmo_code : this.hmoCode,
                provider_name : this.providerName,
                encounter_date : this.encounterDate,
                items:  this.forms.filter(form => form.item !== '' && form.unit_price !== 0 && form.quantity !== 0)
            }
            this.loading = true;
            axios.post('/provider/submit-order', orderData)
                .then(response => {
                   if(response.data.success){
                       this.$toast.success("Order submitted successfully")
                       this.hmoCode = ""
                       this.providerName = ""
                       this.encounterDate = ""
                       this.forms = [
                           { item: '', unit_price: 0, quantity: 0, subTotal: 0 },
                           { item: '', unit_price: 0, quantity: 0, subTotal: 0 }
                       ];
                   }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message)
                })
                .finally(() => {
                    this.loading = false;
                });
        }

    },
    watch: {
        forms: {
            deep: true,
            handler(forms) {
                forms.forEach(this.calculateSubTotal);
            }
        }
    },

};
</script>

<style scoped>
.disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}

</style>
