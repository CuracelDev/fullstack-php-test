<template>
  <div>
    <div class="row align-items-end ju">
      <div class="col">
        <label class="form-label">Item</label>
      </div>
      <div class="col">
        <label class="form-label">Unit Price</label>
      </div>
      <div class="col">
        <label class="form-label">Qty</label>
      </div>
      <div class="col">
        <label class="form-label">Sub Total</label>
      </div>
      <div class="col"></div>
    </div>
    <div
      v-for="(item, idx) in items"
      :key="idx"
      class="row align-items-end mb-3"
    >
      <div class="col">
        <input class="form-control" v-model="item.item" />
      </div>
      <div class="col">
        <input class="form-control" v-model="item.unit" />
      </div>
      <div class="col">
        <input class="form-control" v-model="item.qty" />
      </div>
      <div class="col">
        <input disabled v-model="item.subtotal" class="form-control" />
      </div>

      <div class="col">
        <button type="button" class="btn btn-danger" @click="handleRemove">
          -
        </button>
      </div>
    </div>
    <hr class="mt-5" />
    <div class="row">
      <div class="col">
        <button type="button" class="mt-2 btn btn-success" @click="handleAdd">
          +
        </button>
      </div>

      <div class="col-4 d-flex align-items-center">
         <label for="total" class="form-label mr-2">Total</label>
         <input id="total" class="form-control" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Order",
  data() {
    return {
      items: [
        {
          item: "",
          unit: 0,
          qty: 0,
          subtotal: 0
        },
      ],
    };
  },
  methods: {
    handleAdd() {
      this.items = [
        ...this.items,
        {
          item: "",
          unit: "",
          qty: "",
          subtotal: 0
        },
      ];
    },

    handleRemove(idx) {
      this.items.splice(idx, 1);
    },
  },
};
</script>
