<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">All Coupons</div>
              <div class="card-body" v-for="(item, index) in coupons" :key="index.id">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Coupon Code</th>
                      <th scope="col">Discount</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Assigned to</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">{{ index + 1 }}</th>
                      <td>{{ item.code }}</td>
                      <td>{{ item.discount_percent }}</td>
                      <td>{{ item.product.product_title }}</td>
                      <td>{{ item.user.email }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="my-3">
                <div class="card-header">Create Coupon</div>
              </div>
              <form @submit.prevent="createCoupon" class="text-center">
                <div>
                  <label>Discount Percent</label>
                  <input v-model="discount_percent" type="text" class="form-control">
                </div>
                <div>
                  <label>Select Product</label>
                  <select v-model="products" name="" id="">
                    <option>Pick Product</option>
                    <option v-for="product in products" :key="product.id" value="product.id">
                      {{ product.product_title }}
                    </option>
                  </select>
                </div>
                <div>
                  <label>Select User</label>
                  <select v-model="users" name="" id="">
                    <option>Pick User</option>
                    <option v-for="user in users" :key="user.id" value="user.id">
                      {{ user.email }}
                    </option>
                  </select>
                </div>
                <div>
                  <label>Start Date</label>
                  <input v-model="start_at" type="date" class="form-control">
                </div>
                <div>
                  <label>End Date</label>
                  <input v-model="end_at" type="date" class="form-control">
                </div>
                <div>
                  <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
              </form>
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
    const coupons = ref([])
    const products = ref([])
    const users = ref([])
    const code = ref([])
    const discount_percent = ref([])
    const start_at = ref([])
    const end_at = ref([])

    const createCoupon = async () => {
      await axios.post('roles', {
        name: products.value,
        users: users.value,
        code: code.value,
        discount_percent: discount_percent.value,
        start_at: start_at.value,
        end_at: end_at.value
      });
    }

    const getCoupons = async () => {
      response = await axios.get('coupons', [
        coupons.value = response.data
      ])
    }

    const getProducts = async () => {
      response = await axios.get('products', [
        products.value = response.data
      ])
    }

    const getUser = async () => {
      response = await axios.get('users', [
        users.value = response.data
      ])
    }

    onMounted(getCoupons, getUser, getProducts)

    return{ createCoupon, getCoupons, getProducts, getUser }
  }
}
</script>

<style>

</style>