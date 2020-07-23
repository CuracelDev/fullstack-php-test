<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div
      class="row"
      v-else
    >
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h1>{{ product.name }}
            </h1>
            <pre>&#8358;{{ product.price }}</pre>
            <hr>
            <article>{{ product.details }}</article>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <product-price v-bind="product"></product-price>
      </div>
    </div>
  </div>
</template>

<script>
import ProductPrice from "./ProductPrice";
export default {
  components: {
    ProductPrice
  },
  data() {
    return {
      product: null,
      loading: false
    };
  },
  created() {
    this.loading = true;
    axios.get(`/api/products/${this.$route.params.id}`).then(res => {
      console.log(res);
      this.product = res.data.data;
      this.loading = false;
    });
  }
};
</script>
