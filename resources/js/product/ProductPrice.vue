<template>
  <div>
    <h5 class="text-uppercase text-secondary font-weight-bolder">Total Price</h5>
    <div v-if="coupon_needed">
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="coupon">Coupon</label>
          <span
            v-if="couponValid"
            class="text-success"
          >(valid)</span>
          <input
            type="text"
            name="coupon"
            class="form-control"
            placeholder="Enter Coupon Code"
            v-model="coupon"
            @keyup.enter="applyCoupon"
            :class="[{'is-invalid': this.errorCouponField('coupon')}]"
          >
          <div
            class="invalid-feedback"
            v-if="errors"
          >{{ errors }}</div>
        </div>
      </div>

      <button
        class="btn btn-secondary btn-block"
        @click.prevent="applyCoupon"
        :disabled="loading"
      >Apply!</button>
    </div>
  </div>
</template>


<script>
export default {
  props: { coupon_needed: Number },
  data() {
    return {
      coupon: null,
      loading: false,
      status: null,
      errors: null
    };
  },
  methods: {
    applyCoupon() {
      this.loading = true;

      axios
        .get(
          `/api/products/${this.$route.params.id}/price?coupon=${this.coupon}`
        )
        .then(response => {
          this.status = response.status;
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }

          if (error.response.status === 400) {
            this.errors = error.response.data.message;
          }

          this.status = error.response.status;
        })
        .then(() => {
          this.loading = false;
        });
    },
    errorCouponField(field) {
      return this.hasErrors;
    }
  },
  computed: {
    hasErrors() {
      return (
        (this.status === 422 || this.status === 400) && this.errors !== null
      );
    },
    couponValid() {
      return this.status === 200;
    },
    couponInvalid() {
      return this.status === 400;
    }
  }
};
</script>

<style scoped>
.is-invalid {
  border-color: #b22222;
  background-image: none;
}

.invalid-feedback {
  color: #b22222;
}
</style>