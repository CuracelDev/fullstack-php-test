<template>
    <div>
        <h2 align="center">All Products</h2>
        <div style="clear:both"></div>
        <br/>

        <p v-if="!productsLoaded" align="center"> Please wait ... </p>

        <p v-else-if="count_products == 0" align="center" style="color:red"> No product yet <br/><br/></p>
        
        <div v-else class="row" style="margin-bottom:100px">
            <div v-for="(product, index) in products" :key="index">
                <div class="column">
                    <h4> {{ product.name }} </h4>
                    
                    <p><b>&#8358;{{parseFloat(product.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }}</b></p>
                    
                    <p v-if="product.age_limit_status == 'yes'"> This product has age limit between <b>{{ product.start_age_range}} and {{ product.end_age_range}}</b></p>
                    
                    <p v-if="product.coupon_status == 'yes'"> This product must be bought with a coupon code</p>
                    
                    <p v-if="product.frequency_limit_status == 'yes'"> Time bound frequency - <b>{{ product.frequency_limit}}</b></p>
                    
                    <div align="center">
                        <button class="btn btn-success" :id="`buy-product-btn${product.id}`" @click="buyProduct(product.id, product.coupon_status)">Buy</button>
                        <div :id="`buy-product-status${product.id}`"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

</template>

<script>

    import Functions from '@/components/functions';

    export default {
        data: function () {
            return {
                orders: {
                    product_id: '',
                    coupon_status: '',
                    coupon_code: '',
                },
                products: [],
                count_products: 0,
                productsLoaded: false,
                productsError: false,
            }
        },
        mounted() {
            axios.get('/api/v1/products') 
            .then( async (response) => {
                this.products = await response.data.data;
                this.count_products = this.products.length;
                this.productsLoaded = true;
            })
            .catch( (error) => {
                this.productsError = true;
            });
        },
        methods: {
            async buyProduct(product_id, coupon_status) {
                
                if(coupon_status == 'yes') {
                    const coupon_code = window.prompt('Enter coupon code');
                    this.orders.coupon_code = coupon_code;
                }

                let buy_product_btn = document.querySelector('#buy-product-btn'+product_id);
                let buy_product_status = document.querySelector('#buy-product-status'+product_id);
                Functions.disableBtn('Please wait...', buy_product_btn);
                
                event.preventDefault();
                this.orders.product_id = product_id;
                this.orders.coupon_status = coupon_status;
                const newOrder = this.orders;
                
                await axios({
                    method: 'post',
                    data: newOrder,
                    url: '/api/v1/orders/add-to-cart',
                    headers : {
                        'Content-Type': 'application/json',
                        'x-access-token' : Functions.getCookie('user')
                    }
                })  
                .then(function (response) {
                    if(response.data.type == 'success') {
                        buy_product_status.innerHTML = `<p style='color:green'>Product added to cart.</p>`;
                    } else {
                        buy_product_status.innerHTML = `<p style='color:red'>${response.data.message}</p>`;
                    }
                })
                .catch(function (response) {
                    buy_product_status.innerHTML = "<p style='color:red'>Product not added to cart. Try again</p>";
                });
                setTimeout( () => {
                    buy_product_status.innerHTML = '';
                }, 3000);
                Functions.enableBtn('Buy', buy_product_btn);
            }
        }
    }
</script>

<style scoped>
    
    .column {
        box-shadow: 1px 1px 1px #ccc;
        padding:10px;
        margin:10px;
        border:1px solid #ccc;
    }
</style>
