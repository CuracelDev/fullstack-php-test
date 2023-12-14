<template>
    <div class="container">
        <notifications/>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="providerName">Provider Name</label>
                                <input v-model="providerName" type="text" class="form-control" id="providerName" placeholder="Provider Name" required>
                            </div>
                            <div class="form-group">
                                <label for="hmo">HMO Code</label>
                                <select v-model="hmoCode" name="hmoCode" id="hmoCode" class="custom-select" required >
                                    <option disabled selected>Choose...</option>
                                    <option v-for="(hmo, index) in hmoCodes" :key="index" :value="hmo">{{ hmo }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">Encounter Date</label>
                                <date-picker :date="selectedDate" :option="option"></date-picker>
                            </div>

                            <div v-for="(order, index) in orders" :key="index" class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label v-if="index==0" for="item">Item</label>
                                    <input :value="order.name" @input="(event) => {order.name = event.target.value}" type="text" class="form-control" id="item"  required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="unitPrice">Unit Price</label>
                                    <input :value="order.unit_price" @input="(event) => {if ( event.target.value > 0 )order.unit_price = event.target.value}" type="number" min="1" class="form-control" id="unitPrice" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="quantity">Qty</label>
                                    <input :value="order.quantity" @input="(event) => {if ( event.target.value > 0 ) order.quantity = event.target.value}" type="number" min="1" class="form-control" id="quantity" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="subTotal">Sub Total</label>
                                    <input :value="order.sub_total" type="text" class="form-control" id="subTotal" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label v-if="index==0" for="subTotal">#</label>
                                    <button class="btn btn-secondary" id="remove" @click="removeItem(index)"> - </button>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-1 mb-3">
                                    <button class="btn btn-primary" id="add" @click="addItem()"> + </button>
                                </div>
                                <div class="col-md-2 mb-3 offset-md-7">
                                    <div class="d-flex align-items-center row">
                                        <label >Total</label>
                                        <input :value="total" type="text" class="form-control ml-3" id="total" readonly>
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

<script>
    import DatePicker from 'vue-datepicker';

    export default {
        components: {
            DatePicker,
        },
        data() {
         return {
            hmoCodes: [],
            selectedDate: {
                time: ''
            },
            option: {
                type: 'day',
                week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                format: 'YYYY-MM-DD',
                placeholder: 'Encouter Date',
                inputStyle: {
                    'display': 'inline-block',
                    'padding': '6px',
                    'line-height': '22px',
                    'font-size': '16px',
                    'border': '2px solid #fff',
                    'box-shadow': '0 1px 3px 0 rgba(0, 0, 0, 0.2)',
                    'border-radius': '2px',
                    'color': '#5F5F5F'
                },
                color: {
                header: '#ccc',
                headerText: '#f00'
                },
                buttons: {
                ok: 'Ok',
                cancel: 'Cancel'
                },
                overlayOpacity: 0.5, // 0.5 as default
                dismissible: true // as true as default
            },
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
                this.submitted = true;

                const data = {
                    "hmo_code" : this.hmoCode,
                    "provider_name" : this.providerName,
                    "encounter_date" : this.selectedDate.time,
                    "items": this.orders
                }

                axios.post('/api/submit-order', data, {
                    headers: {
                    'Content-Type': 'application/json'
                }})
                    .then(response => {
                        this.$notify({
                            title: "Success",
                            text:  response.data.message,
                            type: 'success',
                        });

                        this.hmoCode = "";
                        this.providerName = "";
                        this.selectedDate.time = "";
                        this.orders = [
                            {
                                name: "",
                                unit_price: 0,
                                quantity: 0,
                                sub_total: 0,
                            }
                        ];
                    }).catch(error => {

                        this.$notify({
                            title: "Error",
                            text: error.response.data.message ?? "An Error occurred",
                            type: 'error',
                        });
                }).finally(() => {
                    this.submitted = false;
                });
            },
            addItem() {
                this.orders.push({
                    item: "",
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
