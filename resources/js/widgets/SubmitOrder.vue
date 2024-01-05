<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Submit An Order</h4>
                    </div>
                    <div class="card-body">
                        <app-alert v-if="alert" :type="alert.type">
                            {{ alert.text }}
                        </app-alert>
                        <div class="row">
                            <div class="col-5">
                                <app-input label="Receiving HMO" name="hmo_code" :errors="errors" v-model="form.hmo_code" />
                            </div>
                            <div class="col-4">
                                <app-input label="Provider Name" name="provider_name" :errors="errors" v-model="form.provider_name" />
                            </div>
                            <div class="col-3">
                                <app-input label="Encounter date" name="encounter_date" type="date" :errors="errors" v-model="form.encounter_date" />
                            </div>
                        </div>
                        <order-item
                            v-for="(item, i) in form.items"
                            v-model="form.items[i]"
                            :key="`item-${i}`"
                            :item="item"
                            :name="`items.${i}`"
                            :errors="errors"
                            class="order-item-input"
                        >
                            <template #action>
                                <app-button v-if="form.items.length > 1" class="btn btn-sm btn-danger" @click="removeItem(i)">
                                    -
                                </app-button>
                            </template>
                        </order-item>
                        <div class="d-flex justify-content-between align-items-center">
                            <app-button class="btn-primary btn-sm add-item" @click="addItem">
                                +
                            </app-button>
                            <div class="d-flex flex-wrap justify-content-end">
                                <div class="w-100 d-flex justify-content-end align-items-center">
                                    <p>Total:</p>
                                    <app-input v-model="total" readonly disabled />
                                </div>
                                <app-button class="btn btn-primary" :loading="submitting" @click.prevent="submit">
                                    Submit Order
                                </app-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppInput from "../components/AppInput.vue";
    import OrderItem from "./OrderItem.vue";
    import AppButton from "../components/AppButton.vue";
    import orderService from "../services/order";
    import AppAlert from "../components/AppAlert.vue";
    import HmoSelect from "./HmoSelect.vue";
    export default {
        components: {HmoSelect, AppAlert, AppButton, OrderItem, AppInput},
        data() {
            return {
                alert: null,
                errors: null,
                submitting: false,
                form: {}
            }
        },
        computed: {
          total() {
              return (this.form?.items || [])
                  .map(item => item.price * item.quantity)
                  .reduce((sum,next) => sum+next, 0 )
          }
        },
        methods: {
            addItem() {
                this.form.items.push({
                    name: null,
                    price: 0,
                    quantity: 1
                })
            },
            removeItem(index) {
                this.form.items.splice(index, 1)
            },

            reset() {
                this.form = {
                    hmo_code: null,
                    provider_name: null,
                    encounter_date: null,
                    items: []
                }
                // Ensure there is atleast one item
                this.addItem();
            },

            submit() {
                this.submitting = true;
                this.alert = null;
                this.errors = null;
                orderService.createOrder({ ...this.form }).then(() => {
                    this.alert = {
                        text: "Order submitted successfully",
                        type: "success"
                    }
                    this.reset();
                }).catch(e => {
                    this.errors = e.errors
                    this.alert = {
                        text: e.message,
                        type: "danger"
                    }
                }).finally(() => {
                    this.submitting = false;
                })
            }
        },
        mounted() {
            this.reset();
        }
    }
</script>
