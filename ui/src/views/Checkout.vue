<script setup lang="ts">
  import { reactive, computed } from 'vue';
  import CheckoutItem from '../components/CheckoutItem.vue'

  const formData = reactive({
    provider_name: "",
    hmo_code: "",
    date: "",
    items: [
      {
        name: "",
        unit_price: 0,
        quantity: 0,
      }
    ],
  });

  const total = computed(() => {
    let sum = 0;
    formData.items.forEach((item) => sum += (item.unit_price * item.quantity));
    return sum;
  })

  const removeItemRow = (e: Event) => {
    e.preventDefault();
    const index = Number((e.currentTarget as HTMLButtonElement)?.dataset["index"]);
    formData.items.splice(index, 1);
  }

  const addItemsRow = (e: Event) => {
    e.preventDefault();
    formData.items.push({
      name: "",
      unit_price: 0,
      quantity: 0,
    });
  }

  const submitForm = async (e: Event) => {
    console.log("submitting form...")
    e.preventDefault();

    try {
      const res = await (
        await fetch("http://localhost:8000/api/order", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            name: formData.provider_name,
            hmo_code: formData.hmo_code,
            date: formData.date,
            items: formData.items.map(item => ({
              name: item.name,
              unit_price: item.unit_price,
              quantity: item.quantity,
            }))
          })
        })
      ).json();

      console.log(res);
    } catch (error) {
      console.error(error);
    }
  }
</script>

<template>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <form @submit="submitForm">
          <fieldset>
            <div class="row">
              <div class="col-3">
                <div class="mb-3">
                  <label class="mb-2" for="provider_name">Provider Name</label>
                  <input v-model="formData.provider_name" class="form-control" id="provider_name">
                </div>
              </div>
              <div class="col-3">
                <div class="mb-3">
                  <label class="mb-2" for="hmo_code">HMO Code</label>
                  <input v-model="formData.hmo_code" class="form-control" id="hmo_code">
                </div>
              </div>
              <div class="col-2">
                <div class="mb-3">
                  <label class="mb-2" for="date">Date</label>
                  <input v-model="formData.date" class="form-control" id="date">
                </div>
              </div>
            </div>
            <div class="row mb-2 mt-4">
              <div class="col-md-2">Name</div>
              <div class="col-md-2">Unit Price</div>
              <div class="col-md-2">Quantity</div>
              <div class="col-md-2">Sub Total</div>
              <div class="col-md-1"></div>
            </div>
            <CheckoutItem v-for="(checkout_item, index) in formData.items"
              :item="checkout_item"
              :index="index"
              :key="index"
              :removeItemRow="removeItemRow"
            />
            <div class="row mt-2">
              <div class="col-md-6"><button @click="addItemsRow" class="btn btn-secondary">+</button></div>
              <div class="col-md-2">
                <div class="row">
                  <div class="col-2 me-auto d-grid align-content-center">Total</div>
                  <div class="col-6"><input readonly :value="total" class="form-control"></div>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-2">
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</template>
