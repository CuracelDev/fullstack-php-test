<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="px-5">
          <div class="text-center">All Products</div>
          <div class="card" style="width: 18rem;">
            <div class="card-body" v-for="product in products" :key="product.id">
              <h5 class="card-title">{{ product.title }}</h5>
              <p class="card-text">{{ product.description }}</p>
              <button @click="addToCart" class="btn btn-lg btn-success">Add To Cart</button>
            </div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>

import { ref } from '@vue/reactivity'
import { onMounted } from '@vue/runtime-core'
import axios from 'axios'

export default {
  setup(){
    const products = ref([])

    const load = async () => {
      const response = await axios.get(`products`);
      products.value = response.data.data
    }

    const addToCart = async () => {
      await axios.post('carts')
    }

    onMounted(load)

    return{ products, addToCart }
  }
}
</script>

<style>

</style>