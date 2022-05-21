<template>
    <div class="container">
        <br>
        <div class="row ">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Create Order</div>
                    <template v-if="loading">
                        ...loading please wait
                    </template>
                    <order v-else :providers="providers" :hmos="hmos" />
                </div>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-dark">
                        HMO
                        <span class="">Batch Type</span>
                    </li>
                    <template v-if="hmos.length == 0">
                        There no Hmos
                    </template>
                    <li v-else v-for="hmo,i in hmos" :key="i" class="list-group-item d-flex justify-content-between align-items-center">
                        {{hmo.name}} {{hmo.code}}
                        <a :href="`hmos/${hmo.id}/batch-orders`"><span class="badge badge-primary badge-pill">{{hmo.batch_type}}</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Order from './Order.vue'
    export default {
        components:[Order],

        data(){
            return {
                form:{
                    provider_id:null,
                    hmo_id:null,
                    items:[],
                    encounter_date:null,
                    total:0
                },
                hmos:[],
                providers:[],
                loading:false
            }
        },
        mounted() {
            this.addItem()

            this.loading = true
            window.axios.get('/api/hmos').then(res=>{
                
                if(res.status == 200){
                    this.hmos = res.data
                    this.loading = false
                }
            }).catch(err=>{
                this.loading = false
                console.log(err)
                toastr.error("Error, unable to fetch hmos")
            })

            window.axios.get('/api/providers').then(res=>{
                if(res.status == 200){
                    this.providers = res.data
                    this.loading = false
                }
            }).catch(err=>{
                this.loading = false
                console.log(err)
                toastr.error("Error, unable to fetch providers")
            })
        },

        methods:{
            addItem(){
                this.form.items.push({
                    name:'',
                    unitPrice:null,
                    qty:null,
                    subTotal:0
                })
            },

            removeItem(index){
                this.form.items.splice(index,1)
                this.total()
            },

            subTotal(i){
              this.form.items[i].subTotal = this.form.items[i].unitPrice * this.form.items[i].qty
              this.total()
            },

            total(){
               let subTotals = this.form.items.map(ele=>ele.subTotal)
               let total = subTotals.reduce((a,b)=>{return a + b},0)
               this.form.total = total
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
