<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div
        class="row mb-4"
        v-for="row in rows"
        :key="'row' + row"
      >
        <div
          class="col d-flex align-items-stretch"
          v-for="(product, column) in productsInRow(row)"
          :key="'row' + row + column"
        >
          <product-item
            :name="product.name"
            :details="product.details"
            :price="product.price"
          ></product-item>
        </div>
        <div
          class="col"
          v-for="p in placeholdersInRow(row)"
          :key="'placeholder' + row + p"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductItem from "./ProductItem";
export default {
  components: {
    ProductItem
  },
  data() {
    return {
      loading: false,
      columns: 3,
      products: null
    };
  },
  methods: {
    productsInRow(row) {
      return this.products.slice((row - 1) * this.columns, row * this.columns);
    },
    placeholdersInRow(row) {
      return this.columns - this.productsInRow(row).length;
    }
  },
  computed: {
    rows() {
      return this.products === null
        ? 0
        : Math.ceil(this.products.length / this.columns);
    }
  },
  created() {
    this.loading = true;

    axios.get("/api/products").then(res => {
      this.products = res.data;
      this.loading = false;
    });
  }
};
</script>
