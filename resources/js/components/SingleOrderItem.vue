<template>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="name">Item</label>
            <input v-model="item" required class="form-control" type="text" name="name" placeholder="Name" id="name">
        </div>
        <div class="form-group col-md-2">
            <label for="price">Unit Price</label>
            <input v-model="price" required class="form-control" type="number" step=".01" placeholder="Price" id="price">
        </div>
        <div class="form-group col-md-2">
            <label for="quantity">Qty</label>
            <input v-model="quantity" required class="form-control" type="number" step="1" placeholder="Qty" id="quantity">
        </div>
        <div class="form-group col-md-3">
            <label for="subtotal">Subtotal</label>
            <input required :value="subtotal" readonly class="form-control" placeholder="Subtotal" id="subtotal">
        </div>
        <div class="form-group col-md-1">
            <label for="name">Act.</label>
            <button class="form-control" @click="$emit('deleteItem', singleItem.id)">-</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['singleItem'],
    data() {
        return {
            item: this.singleItem.item,
            price: this.singleItem.price,
            quantity: this.singleItem.quantity
        }
    },
    watch: {
        item: {
            handler(newValue, oldValue) {
                this.updateItemValues();
            },
        },
        price: {
            handler(newValue, oldValue) {
                this.updateItemValues();
            },
        },
        quantity: {
            handler(newValue, oldValue) {
                this.updateItemValues();
            },
        },
    },
    methods: {
        updateItemValues() {
            const updatedItem = Object.assign({}, this.singleItem, {item: this.item, price: this.price, quantity: this.quantity});

            this.$emit('updateItem', this.singleItem.id, updatedItem)
        },
    },
    computed: {
        subtotal() {
            return this.price * this.quantity;
        },
    }
}
</script>
