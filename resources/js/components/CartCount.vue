<template>
  <div class="mr-4 mt-3">
    <router-link to="/cart">
      <v-badge
        color="error"
        overlap
      >
        <span slot="badge">{{ cart.length }}</span>
        <v-icon class="mr-1 white--text">mdi-cart</v-icon>
      </v-badge>
    </router-link>
  </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
        name: "CartCount",

        data() {
            return {

            }
        },

        computed: {
            ...mapGetters('cart', ['cart']),
        }
    }
</script>

<style scoped>

</style>