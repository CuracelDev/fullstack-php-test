<template>
    <!-- <div class="order-item"> -->
        <tr v-if="show">
            <td> <input type="text" class="form-control" placeholder="Item" v-model="item"> </td>
            <td> <input type="text" class="form-control" placeholder="Unit Price" v-model="price"> </td>
            <td> <input type="text" class="form-control" placeholder="Quantity" v-model="quantity"> </td>
            <td> <input type="text" class="form-control" disabled placeholder="Sub-Total" v-model="subTotal" ></td>
            <td> <button @click.prevent="remove" class=" form-control btn btn-default"> - </button> </td>
        </tr>
    <!-- </div> -->
</template>

<script>


export default {

    async created() {

    },

    props: {
        total: 0
    },

    data() {
        return {
            item: '',
            price: 0,
            subtotal: 0,
            quantity: 0,
            subTotal: 0,
            show: true,
            reference: Math.random().toString(36).slice(2, 10)

        };
    },

    watch: {
        price: function(val) {
            this.subTotal = this.quantity * val;
            this.updateTotal()
        },

        quantity: function(val) {
            this.subTotal = val * this.price;
            this.updateTotal()
        },

        item: function(val) {
            this.updateTotal()
        },

    },

    methods: {
       
       remove() {
           this.show = false
           this.$emit('remove-total', 
           { subTotal: this.subTotal, reference: this.reference, price: this.price, quantity: this.quantity, item: this.item})
       },

       updateTotal() {
        //   this.total = this.total   
          this.$emit('update-total', 
          { subTotal: this.subTotal, reference: this.reference, price: this.price, quantity: this.quantity, item: this.item})
       }
        
    },

   
};
</script>

<style scoped>
    .btn-default {
        border: solid 1px #ccc;
    }
</style>
