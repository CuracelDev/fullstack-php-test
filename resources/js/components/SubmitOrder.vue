<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Submit An Order</div>

          <div class="card-body">
            <div class="row">
              <div class="col-md">
                <label class="col-form-label">Provider Name</label>
                <input v-model="form.data.provider" :disabled="form.submitting" class="form-control" type="text">
                <p v-if="form.errors.provider" class="error">{{ form.errors.provider }}</p>
              </div>

              <div class="col-md">
                <label class="col-form-label">HMO Code</label>
                <input v-model="form.data.hmo" :disabled="form.submitting" class="form-control" type="text">
                <p v-if="form.errors.hmo" class="error">{{ form.errors.hmo }}</p>
              </div>

              <div class="col-md">
                <label class="col-form-label">Encounter Date</label>
                <input v-model="form.data.encountered_at" :disabled="form.submitting" class="form-control" type="date">
                <p v-if="form.errors.encountered_at" class="error">{{ form.errors.encountered_at }}</p>
              </div>
            </div>

            <div v-if="form.data.items.length" class="row mt-4">
              <div class="col-md-3">
                Item
              </div>

              <div class="col-md-3">
                Unit Price
              </div>

              <div class="col-md-2">
                Qty
              </div>

              <div class="col-md-3">
                Sub Total
              </div>
            </div>

            <div v-for="(item, idx) in form.data.items" :key="idx" class="row mb-2">
              <div class="col-md-3">
                <input v-model="item.name" :disabled="form.submitting" class="form-control" type="text">
                <p v-if="form.errors[`items.${idx}.name`]" class="error">{{ form.errors[`items.${idx}.name`] }}</p>
              </div>

              <div class="col-md-3">
                <input v-model="item.price" :disabled="form.submitting" class="form-control" min="1" type="number">
                <p v-if="form.errors[`items.${idx}.price`]" class="error">{{ form.errors[`items.${idx}.price`] }}</p>
              </div>

              <div class="col-md-2">
                <input v-model="item.qty" :disabled="form.submitting" class="form-control" min="1" type="number">
                <p v-if="form.errors[`items.${idx}.qty`]" class="error">{{ form.errors[`items.${idx}.qty`] }}</p>
              </div>

              <div class="col-md-3">
                <input :value="itemTotal(item)" class="form-control" readonly type="text">
              </div>

              <div class="col-md-1 text-center">
                <button :disabled="form.submitting" class="btn btn-danger btn-md" type="button" @click="removeItem(idx)">
                  -
                </button>
              </div>
            </div>

            <div v-if="form.data.items.length" class="row justify-content-end mt-2">
              <div class="col-auto">
                <label class="col-form-label">Total</label>
              </div>

              <div class="col-md-3">
                <input :value="subTotal" class="form-control" readonly type="text" />
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-4 offset-md-4">
                <div class="form-group text-center">
                  <button :disabled="form.submitting" class="btn btn-success mx-auto" @click="addItem">
                    Add Item
                  </button>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-4 offset-md-4">
                <div class="form-group text-center">
                  <button :disabled="form.submitting" class="btn btn-primary mx-auto" @click="submitForm">
                    {{ form.submitting ? 'Processing...' : 'Submit' }}
                  </button>

                  <p v-if="form.messages.error" class="error">{{ form.messages.error }}</p>
                  <p v-if="form.messages.success" class="success">{{ form.messages.success }}</p>
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
const itemTemplate = () => ({
  name: '',
  price: 0,
  qty: 1,
});

export default {
  mounted() {
    console.log('Component mounted.');
  },

  data() {
    return {
      form: {
        data: {
          hmo: '',
          provider: '',
          items: [itemTemplate()],
          encountered_at: null,
        },
        submitting: false,
        wasSuccessful: false,
        messages: {
          success: '',
          error: '',
        },
        errors: {},
      },
    };
  },

  methods: {
    addItem() {
      this.form.data.items.push(itemTemplate());
    },
    removeItem(index)  {
      this.form.data.items.splice(index, 1);
    },
    itemTotal({ price, qty }) {
      return price * qty;
    },
    submitForm() {
      this.form.submitting = true;
      this.form.messages.error = '';
      this.form.errors = {};

      axios.post('/api/orders', this.form.data)
        .then(response => {
          this.form.wasSuccessful = true;
          this.form.messages.success = 'Order Created';

          setTimeout(() => {
            this.form.wasSuccessful = false;
            this.form.messages.success = '';
          }, 2500);

          this.form.data = {
            hmo: '',
            provider: '',
            items: [itemTemplate()],
            encountered_at: null,
          };
        })
        .catch(error => {
          console.log('error', error);

          if (axios.isAxiosError(error)) {
            const name = ({ method, url }) => {
              return `[${method} => ${url}]`;
            };

            let { message, response, config } = error;
            const data = response?.data;
            const status = response?.status;
            console.log(`responseInterceptor - error: ${name(config)} ${message}`);

            message = data ? data.message || data.error : message;
            message = status && status >= 500 ? 'Something went wrong' : message; // Error message is same if status is 500 and above
            const e = status && status >= 500 ? undefined : data; // Don't need to show trace errors from server

            console.log('API error', { e, message });

            if (status === axios.HttpStatusCode.UnprocessableEntity) {
              this.form.errors = Object.entries(data.errors).reduce(
                (previousValue, [k, v]) => {
                  previousValue[k] = v[0];
                  return previousValue;
                },
                {},
              );
            }

            this.form.messages.error = message;
          }
        })
        .finally(() => {
          this.form.submitting = false;
        })
    },
  },

  computed: {
    subTotal() {
      return this.form.data.items.reduce((total, { price, qty }) => total + (price * qty), 0);
    },
  },
};
</script>

<style>
.error {
  color: red;
  font-size: 12px;
}
.success {
  color: springgreen;
  font-size: 12px;
}
</style>
