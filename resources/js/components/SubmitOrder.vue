<template>
    <div class="container">
        <!-- Container for the order form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>
                    <div class="card-body">
                        <!-- Success alert when order is submitted -->
                        <div v-if="orderSubmitted" class="alert alert-success alert-dismissible fade show" role="alert"
                            data-testid="success-alert">
                            Order was submitted successfully!
                            <button type="button" class="close" @click="dismissAlert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Order form -->
                        <form @submit.prevent="submitOrder" data-testid="order-form">
                            <div class="form-group">
                                <label for="hmoSelect">HMO:</label>
                                <!-- Dropdown for selecting HMO -->
                                <Select2 v-model="order.hmo_id" :options="hmos" @select="handleSelection"
                                    data-testid="hmo-select" />
                            </div>
                            <div class="row">
                                <!-- Display provider name -->
                                <div class="form-group col-6">
                                    <label for="providerName">Provider Name:</label>
                                    <input type="text" class="form-control form-control-sm" :value="provider" readonly
                                        data-testid="provider-name">
                                </div>
                                <!-- Select encounter date -->
                                <div class="form-group col-6">
                                    <label for="encounterDate">Encounter Date:</label>
                                    <input type="date" class="form-control form-control-sm" v-model="order.encounter_date"
                                        required data-testid="encounter-date">
                                </div>
                            </div>
                            <!-- Order items -->
                            <h4 class="my-3">Order Items</h4>
                            <div class="order-item">
                                <table class="table table-sm" data-testid="order-items-table">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="250px">Item</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Sub Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Render each order item -->
                                        <tr v-for="(item, index) in order.items" :key="index"
                                            :data-testid="'order-item-' + index">
                                            <td>
                                                <input v-model="item.name" type="text" class="form-control form-control-sm"
                                                    required data-testid="item-name">
                                            </td>
                                            <td>
                                                <input v-model.number="item.unit_price" @input="calculateSubtotal(index)"
                                                    type="number" class="form-control form-control-sm" required
                                                    data-testid="item-unit-price">
                                            </td>
                                            <td>
                                                <input v-model.number="item.quantity" @input="calculateSubtotal(index)"
                                                    type="number" class="form-control form-control-sm" required
                                                    data-testid="item-quantity">
                                            </td>
                                            <td>
                                                <input :value="item.sub_total.toFixed(2)" type="text"
                                                    class="form-control form-control-sm" readonly
                                                    data-testid="item-sub-total">
                                            </td>
                                            <td>
                                                <button @click="removeItem(index)" type="button"
                                                    :data-testid="`remove-item-btn-${index}`">-</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <!-- Add new item button -->
                                            <td colspan="3"><button @click="addItem" type="button"
                                                    data-testid="add-item-btn">+</button></td>
                                            <!-- Total order amount -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="mr-2">Total</span>
                                                    <input :value="calculateOrderAmount.toFixed(2)" type="text"
                                                        class="form-control form-control-sm" readonly
                                                        data-testid="total-order-amount">
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-success float-right"
                                data-testid="submit-order-btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { http } from '../utils/http';

export default {
    props: {
        // Prop to receive provider name
        provider: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            // Flags to manage order submission state
            submittingOrder: false,
            orderSubmitted: false,
            // Order data structure
            order: {
                hmo_id: '',
                encounter_date: '',
                items: [{ name: '', unit_price: 0, quantity: 0, sub_total: 0 }]
            },
            // Array to store HMO options
            hmos: []
        };
    },
    computed: {
        // Calculate total order amount
        calculateOrderAmount() {
            return this.order.items.reduce((total, item) => total + item.sub_total, 0);
        }
    },
    methods: {
        // Add new item to the order
        addItem() {
            this.order.items.push({ name: '', unit_price: 0, quantity: 0, sub_total: 0 });
        },
        // Remove an item from the order
        removeItem(index) {
            if (this.order.items.length === 1) return;
            this.order.items.splice(index, 1);
        },
        // Calculate subtotal of an item
        calculateSubtotal(index) {
            const item = this.order.items[index];
            item.sub_total = item.unit_price * item.quantity;
        },
        // Submit the order
        async submitOrder() {
            this.submittingOrder = true;
            this.orderSubmitted = false;

            this.order.total = this.calculateOrderAmount;
            await http.post('/orders', this.order);
            this.order = this.orderSchema();

            this.submittingOrder = false;
            this.orderSubmitted = true;
        },
        // Fetch HMO options
        async getHmos() {
            this.hmos = (await http.get('/hmos')).data;
        },
        // Handle selection of HMO
        handleSelection(hmo) {
            this.order.hmo_id = hmo.id;
        },
        // Dismiss the success alert
        dismissAlert() {
            this.orderSubmitted = false;
        },
        // Initialize order structure
        orderSchema() {
            return {
                hmo_id: '',
                encounter_date: '',
                items: [{ name: '', unit_price: 0, quantity: 0, sub_total: 0 }]
            };
        }
    },
    mounted() {
        // Initialize HMO options
        if (process.env.NODE_ENV !== 'test') {
            this.getHmos();
        }
    },
    watch: {
        orderSubmitted(newValue, oldValue) {
            let timer;

            if (newValue === true) {
                timer = setTimeout(() => {
                    this.orderSubmitted = false
                }, 3000)
            } else {
                clearTimeout(timer)
            }
        }
    }
};
</script>

<style scoped>
.order-item {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
}
</style>
