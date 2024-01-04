<template>
    <div class="d-flex justify-content-between align-items-center">
        <div class="row">
            <div class="col-4">
                <app-input label="Item" :name="`${$attrs.name}.name`" :errors="errors" v-model="form.name" />
            </div>
            <div class="col-3">
                <app-input label="Unit Price" :name="`${$attrs.name}.price`" :errors="errors" type="number" v-model="form.price" />
            </div>
            <div class="col-3">
                <app-input label="Qty" :name="`${$attrs.name}.quantity`" :errors="errors" type="number" v-model="form.quantity" />
            </div>
            <div class="col-2">
                <app-input label="Sub" :errors="errors" v-model="subtotal" disabled readonly />
            </div>
        </div>
        <div class="ml-3">
            <slot name="action" v-bind="{ form }" />
        </div>
    </div>
</template>

<script>
    import AppInput from "../components/AppInput.vue";
    export default {
        name: "OrderItem",
        components: {AppInput},
        data() {
            return {
                form: {
                    name: null,
                    price: 0,
                    quantity: 0
                }
            }
        },
        props: {
            item: Object,
            errors: [String, Array, Object]
        },
        computed: {
            subtotal() {
                return this.form.price * this.form.quantity
            }
        },
        watch: {
            form: {
                immediate: true,
                handler(form) {
                    this.$emit("input", form)
                }
            }
        }
    }
</script>
