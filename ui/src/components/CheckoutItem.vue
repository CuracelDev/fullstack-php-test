<script setup lang="ts">
  const props = defineProps(['item', 'removeItemRow', 'index']);
</script>

<template>
  <div class="row mb-2">
    <div class="col-md-2">
      <input v-model="props.item.name" class="form-control">
    </div>
    <div class="col-md-2">
      <input type="number" v-model.number="props.item.unit_price" class="form-control">
    </div>
    <div class="col-md-2">
      <input type="number" v-model.number="props.item.quantity" class="form-control">
    </div>
    <div class="col-md-2">
      <input readonly class="form-control" :value="props.item.unit_price * props.item.quantity">
    </div>
    <div class="col-md-1"><button @click="props.removeItemRow" :data-index="props.index" class="btn btn-secondary">-</button></div>
  </div>
</template>