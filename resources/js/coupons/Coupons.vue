<template>
  <div class="row">
    <div class="col-md-12">
      <h3>All Coupons</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Discount(%)</th>
            <th scope="col">User</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(coupon, index) in coupons"
            :key="index"
          >
            <th scope="row">{{ coupon.id }}</th>
            <td>{{ coupon.code }}</td>
            <td>{{ coupon.discount }}</td>
            <td>{{ coupon.user_id.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      coupons: ""
    };
  },
  methods: {
    getCoupons() {
      axios.get("/api/coupons").then(res => {
        this.coupons = res.data.data;
      });
    }
  },
  created() {
    this.getCoupons();
  }
};
</script>