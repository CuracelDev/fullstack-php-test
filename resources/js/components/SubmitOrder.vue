<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        <div class="error">
                            <div v-for="(er, key) in error">
                                <span class="error-label">{{ key }} :</span><span>{{ error[key][0] }}</span>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-row">

                                <div class="col-md-5">
                                    <label>Provider Name:</label>
                                    <input type="text" v-model="order.provider_name" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label>HMO Code:</label>
                                    <input type="text" v-model="order.hmo_code" class="form-control">
                                </div>
                                <div class="col-md-5">
                                    <label>Encounter Date:</label>
                                    <input type="date" v-model="order.encounter_date" class="form-control">
                                </div>

                             </div>

                            <div class="form-row">

                                <div class="col-md-6">
                                    Item
                                </div>
                                <div class="col-md-2">
                                   Unit Price
                                </div>
                                <div class="col-md-1">
                                    Qty
                                </div>
                                <div class="col-md-2">
                                    Sub Total
                                </div>
                                <div class="col-md-1">
                                </div>

                            </div>
                            
                            <!-- Items -->
                            <div class="form-row" v-for="(item,i) in order.items" :key="i">
                                <div class="col-md-6">
                                    <input type="text" v-model="item.name" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" @keyup="getSubTotal(item, i)" 
                                    v-model="item.unit_price" 
                                    class="form-control"
                                    :id="'unit'+i" >
                                </div>
                                <div class="col-md-1">
                                    <input type="text" @keyup="getSubTotal(item, i)" 
                                    v-model="item.quantity" 
                                    class="form-control" 
                                    :id="'qty'+i">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" :id="'sub'+i" :value="getSubTotal(item, i)" readonly class="form-control" >
                                </div>
                                <div class="col-md-1">
                                    <button @click="removeItem(i)" :id="'remove-button'+i" class="btn btn-default remove-button">-</button>
                                </div>
                            </div>

                            <!-- Controls -->
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button @click="addItem()" id="add-button" class="btn btn-default remove-button">+</button>
                                </div>
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    Total
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="total" readonly class="form-control" v-model="total" >
                                </div>
                                <div class="col-md-1">
                                    
                                </div>
                            </div>

                             <!-- Submit -->
                             <div class="form-row">
                                <div class="col-6">
                                    <button @click="submit()" 
                                    :disabled="submitting"
                                    class="btn btn-info submit">{{ submitting ? 'Please wait..' : 'Submit' }}
                                </button>
                                </div>
                            </div>


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
                error:{},
                order: {
                    provider_name:'',
                    hmo_code:'',
                    encounter_date: '',
                    items:[
                        {
                            name:'',
                            quantity:'',
                            unit_price:'',
                            sub_total:''
                        }
                    ]
                },
                submitting : false
            }
        },
        mounted() {
            
        },
        methods:{
            addItem() {
                this.order.items.push({
                            name:'',
                            quantity:'',
                            unit_price:'',
                            sub_total:''
                        });
            },
            removeItem(i) {
                this.order.items.splice(i,1);
            },
            getSubTotal(item, i) {
                if (item.unit_price && item.quantity) {
                    let sub_total = item.unit_price * item.quantity;
                    this.order.items[i].sub_total = sub_total;
                    return sub_total;
                } 

                return 0;
            },
            submit() {
                this.submitting = true;
                this.error = {};
                axios.post('/api/orders', this.order)
                .then(response => {
                    
                    this.$fire({
                        title: "Curacel",
                        text: response.data.message,
                        type: "success",
                        timer: 3000
                        }).then(r => {
                      
                    });
                }).catch(error => {
                    this.error = error.response.data;
                }).finally(() => {
                    this.submitting = false;
                })
            }
        },
        computed:{
            total: function() {
                return this.order.items.reduce((sum, item) => {
                    let quanity = item.quantity || 0;
                    let price = item.unit_price || 0;
                    return sum + (quanity * price);
                }, 0)
            }
        }
    }
</script>

<style>
.remove-button {
    background-color: rgb(233, 231, 231);
}
.form-row {
    padding-bottom: 10px;
}

.submit {
    width: 120px;
}
.error-label {
    color:#ff0000;
}

.error{
    background-color: rgb(243, 220, 177);
}
</style>
