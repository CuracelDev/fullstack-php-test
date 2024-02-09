<template>
    <div>
        <div class="container">
            <div class="col-md-10 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Order</h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{ 'has-error': errors.provider }"
                                >
                                    <label>Provider Name</label>
                                    <input
                                        v-model="provider"
                                        type="text"
                                        class="form-control"
                                        required
                                        @focus="clearError('provider')"
                                    />

                                    <div v-if="errors.provider" class="error-message">
                                        {{ errors.provider }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" :class="{ 'has-error': errors.hmo_id }">
                                <div class="form-group">
                                    <label>HMO Code</label>
                                    <select
                                        v-model="hmo_id"
                                        class="form-control"
                                        required
                                        @focus="clearError('hmo_id')"
                                    >
                                        <option value="" disabled selected>Select HMO</option>
                                        <option
                                            v-for="hmo in hmoCodes"
                                            :key="hmo.id"
                                            :value="hmo.id"
                                        >
                                            {{ hmo.code }}
                                        </option>
                                    </select>
                                    <div v-if="errors.hmo_id" class="error-message">
                                        {{ errors.hmo_id }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div
                                    class="form-group"
                                    :class="{ 'has-error': errors.encounter_date }"
                                >
                                    <label>Encounter Date</label>
                                    <input
                                        v-model="encounter_date"
                                        type="date"
                                        required
                                        class="form-control"
                                        @focus="clearError('encounter_date')"
                                    />
                                    <div v-if="errors.encounter_date" class="error-message">
                                        {{ errors.encounter_date }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br /><br />

                        <div class="items-container">
                            <div v-for="(item, index) in items" :key="index" class="row">
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-error': errors[`items[${index}].name`] }"
                                    >
                                        <label>Item</label>
                                        <input
                                            v-model="item.name"
                                            type="text"
                                            required
                                            class="form-control"
                                            @focus="clearError(`items[${index}].name`, index)"
                                        />
                                        <div
                                            v-if="errors[`items[${index}].name`]"
                                            class="error-message"
                                        >
                                            {{ errors[`items[${index}].name`] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div
                                        class="form-group"
                                        :class="{'has-error': errors[`items[${index}].price`]}"
                                    >
                                        <label>Unit Price</label>
                                        <input
                                            v-model="item.price"
                                            type="number"
                                            class="form-control"
                                            min="1"
                                            @focus="clearError(`items[${index}].price`, index)"
                                            @input="updateSubtotal(index)"
                                        />
                                        <div
                                            v-if="errors[`items[${index}].price`]"
                                            class="error-message"
                                        >
                                            {{ errors[`items[${index}].price`] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-error': errors[`items[${index}].quantity`] }"
                                    >
                                        <label>Quantity</label>
                                        <input
                                            v-model="item.quantity"
                                            type="number"
                                            class="form-control"
                                            required
                                            min="1"
                                            @focus="clearError(`items[${index}].quantity`, index)"
                                            @input="updateSubtotal(index)"
                                        />
                                        <div
                                            v-if="errors[`items[${index}].quantity`]"
                                            class="error-message"
                                        >
                                            {{ errors[`items[${index}].quantity`] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub-Total</label>
                                        <input
                                            :value="item.subTotal"
                                            type="number"
                                            class="form-control"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button
                                            @click="removeItem(index)"
                                            class="btn btn-danger"
                                            style="margin-top: 1.5rem"
                                        >
                                            -
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group mt-2">
                                    <button @click="addItem" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center justify-content-end mt-3">
                            <div class="col-auto">
                                <label for="total" class="col-form-label">Total</label>
                            </div>
                            <div class="col-auto">
                                <input
                                    v-bind:value="total"
                                    type="text"
                                    id="total"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <button @click="submitForm" class="btn btn-primary" :disabled="isLoading">
                                        Submit
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
import axios from "axios";
export default {
    data() {
        return {
            provider: "",
            hmo_id: "",
            encounter_date: "",
            items: [{ name: "", price: "", quantity: "", subTotal: "" }],
            total: 0,
            hmoCodes: [],
            errors: {},
            isLoading: false
        };
    },
    methods: {
        addItem() {
            this.items.push({ name: "", price: "", quantity: "", subTotal: "" });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
                this.calculateTotal();
            }
        },
        updateSubtotal(index) {
            const item = this.items[index];
            item.price = Math.max(0, item.price);
            item.quantity = Math.max(0, item.quantity);
            item.subTotal = item.price * item.quantity;
            this.calculateTotal();
        },
        calculateTotal() {
            this.total = this.items.reduce((sum, item) => sum + item.subTotal, 0);
        },
        validateForm() {
            this.errors = {};
            if (!this.provider) {
                this.$set(this.errors, "provider", "Provider Name is required.");
            }
            if (!this.hmo_id) {
                this.$set(this.errors, "hmo_id", "HMO Code is required.");
            }
            if (!this.encounter_date) {
                this.$set(this.errors, "encounter_date", "Encounter date is required.");
            }
            // Validate items
            this.items.forEach((item, index) => {
                if (!item.name) {
                    this.$set(
                        this.errors,
                        `items[${index}].name`,
                        "Item name is required."
                    );
                }
                if (item.price <= 0) {
                    this.$set(
                        this.errors,
                        `items[${index}].price`,
                        "Price must be greater than 0."
                    );
                }
                if (item.quantity <= 0) {
                    this.$set(
                        this.errors,
                        `items[${index}].quantity`,
                        "Quantity must be greater than 0."
                    );
                }
            });

            return Object.keys(this.errors).length === 0;
        },
        clearError(field, index) {
            if (field.includes("items[")) {
                const fieldName = field.split(".").pop();
                this.$delete(this.errors, `items[${index}].${fieldName}`);
            } else {
                this.$delete(this.errors, field);
            }
        },
        async submitForm() {
            if (this.validateForm()) {
                this.isLoading = true

                await axios.post("/api/orders",
                    {
                        provider: this.provider,
                        hmo_id: this.hmo_id,
                        encounter_date: this.encounter_date,
                        items: this.items.map((item) => ({
                            item: item.name,
                            price: item.price,
                            quantity: item.quantity,
                        })),
                    }
                )
                    .then((response) => {
                    this.showToast("success", response.data.message);
                    this.resetForm();
                })
                    .catch((error) => {
                        this.showToast("error", error.response.data.message)
                    })
                    .finally(() => this.isLoading = false);
            }
        },
        resetForm() {
            this.provider = "";
            this.hmoCode = "";
            this.encounter_date = "";
            this.items = [{ name: "", price: "", quantity: "", subTotal: "" }];
            this.total = 0;
        },
        async getHMOCodes() {
            await axios.get(`/api/hmos`)
                .then(({ data }) => {
                    this.hmoCodes = data.data.map((hmo) => ({
                        id: hmo.id,
                        code: hmo.code,
                    }));

                    this.hmoCodes.length > 0 && (this.hmoCode = this.hmoCodes[0].id);
                })
                .catch((error) => {
                    this.showToast("error", "Error fetching HMO codes.");
                });
        },
        showToast(type, message) {
            this.$toastr[type](message);
        },
    },
    beforeMount() {
        this.getHMOCodes();
    },
};
</script>

<style scoped>
.error-message {
    color: red;
    font-size: smaller;
}
.has-error input {
    border: 1px solid red;
}
</style>
