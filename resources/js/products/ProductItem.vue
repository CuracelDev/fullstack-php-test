<template>
  <div class="card w-100">
    <div class="card-body">
      <router-link :to="{name: 'product'
        ,
        params:
        {id}}">
        <h5 class="card-title">{{ name }}
          <pre>&#8358;{{ price }}</pre>
        </h5>
      </router-link>
      <p class="card-text">{{ details }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: { name: String, details: String, price: Number, id: Number }
};
</script>
