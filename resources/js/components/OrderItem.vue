<template>
    <!-- <div class="order-item"> -->
        <tr v-if="show">
            <td> <input type="text" class="form-control" placeholder="Item" v-model="itemDetails.item"> </td>
            <td> <input type="text" class="form-control" placeholder="Unit Price" v-model="itemDetails.price"> </td>
            <td> <input type="text" class="form-control" placeholder="Quantity" v-model="itemDetails.quantity"> </td>
            <td> <input type="text" class="form-control" disabled placeholder="Sub-Total" v-model="itemDetails.subtotal" @click.prevent="calculateSubTotal"> </td>
            <td> <button @click.prevent="remove" class=" form-control btn btn-default"> - </button> </td>
        </tr>
    <!-- </div> -->
</template>

<script>


export default {
    components: {
    },

    async created() {

    },

    data() {
        return {
            itemDetails: {
                item: '',
                price: 0,
                subtotal: 0,
                quantity: 0,
            },
            show: true
        };
    },

    watch: {
        itemDetails: {
            handler() {
                this.itemDetails.forEach(item => {
                    item.subtotal = item.price * item.quantity;
                });
            }, 
            deep: true
        }
    },

    methods: {
       
       calculateSubTotal() {
           console.log(this.itemDetails)
           let itemDetails = this.itemDetails
           itemDetails.subtotal = itemDetails.price * itemDetails.quantity
           this.itemDetails = itemDetails
           return
       },

       remove() {
          return this.show = false
       }
        
    },

    watch: {
        // calculateSubTotal: itemDetails
    },
};
</script>

<style scoped>
    .btn-default {
        border: solid 1px #ccc;
    }
</style>
