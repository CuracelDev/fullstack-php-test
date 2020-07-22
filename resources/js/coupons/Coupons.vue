<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <!-- <div
        class="row mb-4"
        v-for="row in rows"
        :key="'row' + row"
      >
        <div
          class="col d-flex align-items-stretch"
          v-for="(product, column) in productsInRow(row)"
          :key="'row' + row + column"
        >
          <product-item v-bind="product"></product-item>
        </div>
        <div
          class="col"
          v-for="p in placeholdersInRow(row)"
          :key="'placeholder' + row + p"
        ></div>
      </div> -->
      <h1>Coupons</h1>
    </div>
  </div>
</template>

<script>
// import ProductItem from "./ProductItem";
export default {
  components: {
    // ProductItem
  },
  data() {
    return {
      loading: false,
      columns: 3,
      products: null
    };
  }
};
</script>
