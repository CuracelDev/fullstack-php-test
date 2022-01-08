<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">Checkout Page</div>
              <div class="card-body">
                <div class="card" style="width: 18rem;">
                  <div class="card-body" v-for="product in products" :key="product.id">
                    <div v-for="item in product" :key="item.id">
                      <h5 class="card-title">{{ product.title }}</h5>
                      <p class="card-text">{{ product.price }}</p>
                    </div>
                    <div>
                      <div>Total Price: {{ product.grand_total }}</div>
                      <div v-if="products.plus_tax != null">Total Price: {{ product.plus_tax }}</div>
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

import { ref } from '@vue/reactivity'
import { onMounted } from '@vue/runtime-core'
import axios from 'axios'

export default {
  setup(){
    const cartItems = ([])

    const getCart = async () => {
      response = await axios.get('getcart', [
        cartItems = response.data
      ])
    }

    onMounted(load)

    return { getCart }
  }
}
</script>

<style>

</style>