<template>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">Welcome, Kindly Submit your orders here</div>

                    <div class="card-body">

                        <h3 class="text-center">Order Information</h3>

                        <div class="form-group row">
                            <label for="hmo_code" class="col-md-4 col-form-label text-md-right">HMO Code</label>

                            <div class="col-md-6">
                                <input id="hmo_code" type="text" class="form-control" name="hmo_code" v-model="hmoCode">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provider_name" class="col-md-4 col-form-label text-md-right">Provider Name</label>

                            <div class="col-md-6">
                                <input id="provider_name" type="text" class="form-control" name="provider_name" v-model="providerName">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="encounter_date" class="col-md-4 col-form-label text-md-right">Encounter Date</label>

                            <div class="col-md-6">
                                <input id="encounter_date" type="date" class="form-control" name="encounter_date" v-model="encounterDate">
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
                                <div class="col"><input type="text" v-model="form.item" class="form-control"></div>
                                <div class="col"><input type="number" v-model="form.unitPrice" class="form-control"></div>
                                <div class="col"><input type="number" v-model="form.quantity" class="form-control"></div>
                                <div class="col"><input type="number" :value="form.subTotal" class="form-control" disabled></div>
                                <div class="col-auto"><button @click="removeForm(index)" class="btn btn-danger">-</button></div>
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
                            <button type="submit" class="btn btn-success mt-3">Submit Order</button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            forms: [
                { item: '', unitPrice: 0, quantity: 0, subTotal: 0 },
                { item: '', unitPrice: 0, quantity: 0, subTotal: 0 }
            ],
            encounterDate:"",
            providerName:"",
            hmoCode:""

        };
    },
    computed: {
        total() {
            return this.forms.reduce((acc, form) => acc + form.subTotal, 0);
        }
    },
    methods: {
        addForm() {
            this.forms.push({ item: '', unitPrice: 0, quantity: 0, subTotal: 0 });
        },
        removeForm(index) {
            this.forms.splice(index, 1);
        },
        calculateSubTotal(form) {
            form.subTotal = form.unitPrice * form.quantity;
        }
    },
    watch: {
        forms: {
            deep: true,
            handler(forms) {
                forms.forEach(this.calculateSubTotal);
            }
        }
    }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
```

With this setup, the labels are positioned on top of the input fields, and the remove buttons are aligned with the inputs.
