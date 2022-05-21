<template>
     <div class="card">
        <div class="card-header">Create Order</div>
        <form @submit.prevent="submit()">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Provider</label>
                    <select v-model="form.provider_id" class="form-control">
                        <option :value="null">Select Provider</option>
                        <option v-for="provider,i in providers" :key="i" :value="provider.id">{{provider.name}} - {{provider.email}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">HMO</label>
                    <select v-model="form.hmo_id" class="form-control">
                        <option :value="null">Select Hmo</option>
                        <option v-for="hmo,i in hmos" :key="i" :value="hmo.id">{{hmo.name}} - {{hmo.code}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Encounter Date</label>
                    <input v-model="form.encounter_date" type="date" class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                    
                    <span>Order Item</span>
                    <hr>
                    <template v-for="item,i in form.items" >
                        <div class="form-row" :key="i">
                            <div class="col">
                                <label for="exampleInputEmail1">name</label>
                                <input v-model="item.name" type="text" class="form-control">
                            </div>
                            <div class="col">
                                <label for="exampleInputEmail1">Unit price</label>
                                <input min="1" :id="'unit-price'+i" v-model="item.unitPrice" @change="subTotal(i)" type="number" class="form-control">
                            </div>
                            <div class="col">
                                <label for="exampleInputEmail1">Qty</label>
                                <input min="1" :id="'qty'+i" v-model="item.qty" @change="subTotal(i)" type="number" class="form-control">
                            </div>
                            <div class="col">
                                <label for="exampleInputEmail1">Sub total</label>
                                <input readonly :id="'subTotal'+i" v-model="item.subTotal" type="number" class="form-control">
                            </div>
                            <div class="col">
                                <label for="exampleInputEmail1">&nbsp;</label>
                                <button :id="'remove'+i" title="remove item" type="button" class="form-control btn-primary" @click="removeItem(i)">-</button>
                            </div>
                        </div>
                    </template>
                    <br>
                    <div class="row">
                        <div class="col">
                            <button id="add" title="add item" type="button" class="btn btn-primary" @click="addItem()">+</button>
                        </div>
                        <div class="col">
                            <input type="number" id="total" readonly v-model="form.total" class="form-control" placeholder="Total">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="form-control btn btn-primary">Submit</button>
                    
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:{
            hmos:{
                type:Array,
                required:false
            },
            providers:{
                type:Array,
                required:false
            }
        },

        mounted(){
            this.addItem()
        },

        data(){
            return {
                form:{
                    provider_id:null,
                    hmo_id:null,
                    items:[],
                    encounter_date:null,
                    total:0
                },
                
            }
        },

        methods:{
            addItem(data){
                if(data){
                    this.form.items.push(data)
                }else{
                        this.form.items.push(data || {
                        name:'',
                        unitPrice:null,
                        qty:null,
                        subTotal:0
                    })
                }
                
            },

                removeItem(index){
                    this.form.items.splice(index,1)
                    this.total()
                },

                subTotal(i){
                this.form.items[i]['subTotal'] = this.form.items[i].unitPrice * this.form.items[i].qty
                this.total()
                return this.form.items[i].subTotal
                },

                total(){
                let subTotals = this.form.items.map(ele=>ele.subTotal)
                let total = subTotals.reduce((a,b)=>{return a + b},0)
                return this.form.total = total
                },

                submit(){
                    axios.post('/api/orders',this.form).then(res=>{
                        if(res.status == 200){
                            toastr.success('Order created successfully')
                        }
                    }).catch(err=>{
                        console.log(err.response)
                        if(err.response.status == 422){
                            toastr.error(err.response.data.message)
                        }else{
                            toastr.error('An error occured')
                        }
                    })
                }
        }
    }
</script>