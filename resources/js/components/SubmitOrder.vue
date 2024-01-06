<template>
  <div>
    <div class="container">
      <div class="col-md-10 m-auto">
        <div class="card">
          <div class="card-header">
            <h1 class="card-title">Order Form</h1>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div
                  class="form-group"
                  :class="{ 'has-error': errors.providerName }"
                >
                  <label>Provider Name</label>
                  <input
                    v-model="providerName"
                    type="text"
                    class="form-control"
                    @focus="clearError('providerName')"
                  />

                  <div v-if="errors.providerName" class="error-message">
                    {{ errors.providerName }}
                  </div>
                </div>
              </div>

              <div class="col-md-4" :class="{ 'has-error': errors.hmoCode }">
                <div class="form-group">
                  <label>HMO Code</label>
                  <select
                    v-model="hmoCode"
                    class="form-control"
                    @focus="clearError('hmoCode')"
                  >
                    <option value="" disabled selected>Select HMO</option>
                    <option
                      v-for="hmo in hmoCodes"
                      :key="hmo.id"
                      :value="hmo.code"
                    >
                      {{ hmo.code }}
                    </option>
                  </select>
                  <div v-if="errors.hmoCode" class="error-message">
                    {{ errors.hmoCode }}
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div
                  class="form-group"
                  :class="{ 'has-error': errors.encounterDate }"
                >
                  <label>Encounter Date</label>
                  <input
                    v-model="encounterDate"
                    type="date"
                    class="form-control"
                    @focus="clearError('encounterDate')"
                  />
                  <div v-if="errors.encounterDate" class="error-message">
                    {{ errors.encounterDate }}
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
                    :class="{
                      'has-error': errors[`items[${index}].unitPrice`],
                    }"
                  >
                    <label>Unit Price</label>
                    <input
                      v-model="item.unitPrice"
                      type="number"
                      class="form-control"
                      @focus="clearError(`items[${index}].unitPrice`, index)"
                      @input="updateSubtotal(index)"
                    />
                    <div
                      v-if="errors[`items[${index}].unitPrice`]"
                      class="error-message"
                    >
                      {{ errors[`items[${index}].unitPrice`] }}
                    </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div
                    class="form-group"
                    :class="{ 'has-error': errors[`items[${index}].quantity`] }"
                  >
                    <label>Qty</label>
                    <input
                      v-model="item.quantity"
                      type="number"
                      class="form-control"
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
                      style="margin-top: 1.8rem"
                    >
                      -
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
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
                  <button @click="submitForm" class="btn btn-primary">
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
      providerName: "",
      hmoCode: "",
      encounterDate: "",
      items: [{ name: "", unitPrice: "", quantity: "", subTotal: "" }],
      total: 0,
      hmoCodes: [],
      errors: {},
    };
  },
  methods: {
    addItem() {
      this.items.push({ name: "", unitPrice: "", quantity: "", subTotal: "" });
    },
    removeItem(index) {
      if (this.items.length > 1) {
        this.items.splice(index, 1);
        this.calculateTotal();
      }
    },
    updateSubtotal(index) {
      const item = this.items[index];
      item.unitPrice = Math.max(0, item.unitPrice);
      item.quantity = Math.max(0, item.quantity);
      item.subTotal = item.unitPrice * item.quantity;
      this.calculateTotal();
    },
    calculateTotal() {
      this.total = this.items.reduce((sum, item) => sum + item.subTotal, 0);
    },

    validateForm() {
      this.errors = {};

      if (!this.providerName) {
        this.$set(this.errors, "providerName", "Provider Name is required.");
      }

      if (!this.hmoCode) {
        this.$set(this.errors, "hmoCode", "HMO Code is required.");
      }

      if (!this.encounterDate) {
        this.$set(this.errors, "encounterDate", "Encounter date is required.");
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

        if (item.unitPrice <= 0) {
          this.$set(
            this.errors,
            `items[${index}].unitPrice`,
            "Unit Price must be greater than 0."
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
      // Clear the error for the specified field of a specific item when it gains focus
      if (field.includes("items[")) {
        // For items array, use the index to clear the error
        const fieldName = field.split(".").pop(); // Extract the field name (e.g., "name", "unitPrice", "quantity")
        this.$delete(this.errors, `items[${index}].${fieldName}`);
      } else {
        // For other fields, directly clear the error
        this.$delete(this.errors, field);
      }
    },
    async submitForm() {
      if (this.validateForm()) {
        try {
          const response = await axios.post(process.env.MIX_API_URL+
            "/orders",
            {
              provider_name: this.providerName,
              hmo_code: this.hmoCode,
              encounter_date: this.encounterDate,
              items: this.items.map((item) => ({
                item: item.name,
                price: item.unitPrice,
                quantity: item.quantity,
              })),
            }
          );

          this.showToast("success", response.data.message);

          this.resetForm();
        } catch (error) {
          if (
            error.response &&
            error.response.data &&
            error.response.data.error_type === "validation_error" &&
            error.response.data.errors &&
            error.response.data.errors.encounter_date
          ) {
            this.showToast(
              "error",
              error.response.data.errors.encounter_date[0]
            );
          } else {
            console.log(error.response.data);
            this.showToast("error", "Error submitting form. Please try again.");
          }
        }
      }
    },

    resetForm() {
      this.providerName = "";
      this.hmoCode = "";
      this.encounterDate = "";
      this.items = [{ name: "", unitPrice: "", quantity: "", subTotal: "" }];
      this.total = 0;
    },

    async getHMOCodes() {
        try
      {
        const response = await fetch(process.env.MIX_API_URL +"/hmos");
        const data = await response.json();
        if (data.status) {
          this.hmoCodes = data.data.map((hmo) => ({
            id: hmo.id,
            code: hmo.code,
          }));

          // Set the default HMO code to the first item in the array
          if (this.hmoCodes.length > 0) {
            this.hmoCode = this.hmoCodes[0].code;
          }
        } else {
          this.showToast("error", "Error fetching HMO codes.");
        }
      } catch (error) {
        this.showToast("error", "Error fetching HMO codes.");
      }
    },

    showToast(type, message) {
      this.$toastr[type](message);
    },
  },

  created() {
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
  