<template>
    <div class="col-md-6 col-md-offset-2" style="margin:auto">
        <div class="form-group">
            <router-link :to="{name: 'coupons'}" class="btn btn-success">View all coupons</router-link>
        </div>
        <h2>Add new coupons </h2>
        <div>
            <form v-on:submit="addCoupon()">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Code</label>
                        <input type="text" v-model="coupon.code" minlength="5" maxlength="15" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Tax</label>
                        <input type="text" v-model="coupon.tax" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success" id="add-coupon-btn">Add</button>
                        <div id="add-coupon-status"></div>
                    </div>
                </div>
            </form>
        </div>
        <br/><br/>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                coupon: {
                    code: '',
                    tax: '',
                }
            }
        },
        methods: {
            async addCoupon() {
                event.preventDefault();
                let add_coupon_btn = document.querySelector('#add-coupon-btn');
                let add_coupon_status = document.querySelector('#add-coupon-status');
                const app = this;
                const newCoupon = app.coupon;
                
                add_coupon_btn.disabled = true;
                add_coupon_btn.innerHTML = "Please wait...";
                
                await axios.post('/api/v1/coupons/add', newCoupon)
                    .then(function (response) {
                        if(response.data.type == 'success') {
                            add_coupon_status.innerHTML = `<p style='color:green'>Coupon added.</p>`;
                            setTimeout( () => {
                                app.$router.push({path: '/coupons'});
                            }, 500);
                        } else {
                            add_coupon_status.innerHTML = `<p style='color:red'>${response.data.message}</p>`;
                        }
                    })
                    .catch(function (response) {
                        add_coupon_status.innerHTML = "<p style='color:red'>Coupon not added. Try again</p>";
                    });
                add_coupon_btn.disabled = false;
                add_coupon_btn.innerHTML = "Add";
            }
        }
    }
</script>
