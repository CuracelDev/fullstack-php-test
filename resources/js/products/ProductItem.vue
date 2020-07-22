<template>
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title">{{ name }}</h5>
      <p class="card-text">{{ details }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: { name: String, details: String, price: Number }
};
</script>
