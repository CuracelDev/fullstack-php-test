<template>
    <div class="container">
        <br>
        <h3>Batch By {{batchType == 'created_at' ? 'Sent Date' : 'Encounter Date'}}</h3>
        <div class="row">
            <div class="col-md -8 offset-2">
                <div id="accordion">
                    <div class="card" v-for="batch,i in batches" :key="i">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Batch of {{getMonth[new Date(i).getMonth()]}} - {{new Date(i).getFullYear()}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <ul class="list-group">
                                <template v-for="item, index in batch">
                                    <li :key="index" class="list-group-item d-flex justify-content-between align-items-center">
                                    Encounter date - {{item.encounter_date}} <br>
                                    Sent Date - {{item.sent_date}} <br>
                                    Items - {{item.items}} 
                                        
                                    </li>
                                </template>
                                </ul>
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
    props:{
        id:{
            type:String,
            required:true
        },
        batchType:{
            type:String,
            required:true
        }
    },

    data(){
        return{
            batches:[]
        }
    },

    computed:{
        getMonth(){
            return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
        }
    },

    mounted(){
        axios.get(`/api/hmos/${this.id}/batch-order`).then(res=>{
            if(res.status == 200){
                this.batches = res.data
            }
        }).catch(err=>{
            console.log(err)
            toastr.error("An error occured")
        })
    }
}
</script>