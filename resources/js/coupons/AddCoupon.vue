<template>
  <div class="row">
    <div class="col-md-12">
      <h3>Add New Coupon</h3>
      <form>
        <div class="form-group">
          <label for="coupon">Coupon Code</label>
          <input
            name="code"
            type="text"
            id="coupon"
            v-model="code"
            class="form-control"
            placeholder="Enter the Coupon Code"
          >
        </div>
        <div class="form-group">
          <label for="discount">Coupon Discount</label>
          <input
            name="discount"
            type="number"
            id="discount"
            v-model="discount"
            class="form-control"
            placeholder="Enter the Coupon Discount Percentage ex 5, 12"
          >
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Select User</label>
          <select
            name="user_id"
            class="form-control"
            id="exampleFormControlSelect1"
            v-model="user_id"
          >
            <option
              v-for="user in users"
              :key="user.id"
              :value="user.id"
            >{{ user.name }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect2">Select Product(s)</label>
          <select
            name="product_id"
            multiple
            class="form-control"
            id="exampleFormControlSelect2"
            v-model="product_id"
          >
            <option
              v-for="product in products"
              :key="product.id"
              :value="product.id"
            >{{ product.name }}</option>
          </select>
        </div>
        <button
          type="submit"
          class="btn btn-primary"
          @click.prevent="addCoupon"
        >Add</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      products: "",
      users: "",
      code: "",
      discount: "",
      user_id: "",
      product_id: []
    };
  },
  methods: {
    addCoupon() {
      try {
        if (this.code && this.discount && this.user_id && this.product_id) {
          let data = {
            code: this.code,
            discount: this.discount,
            user_id: this.user_id,
            product_id: this.product_id
          };

          axios.post("/api/coupons", data);

          alert("Coupon created successfully!");
          this.$router.push("/coupons");
        } else {
          alert("All fields are required!");
        }
      } catch (err) {
        alert(err);
      }
    },
    fetchProducts() {
      axios.get("/api/products").then(res => {
        this.products = res.data.data;
      });
    },
    fetchUsers() {
      axios.get("/api/users").then(res => {
        this.users = res.data.data;
        this.loading = false;
      });
    }
  },
  created() {
    this.loading = true;
    this.fetchProducts();
    this.fetchUsers();
  }
};
</script>