<template>
    <div>
        <h6 class="pt-5 text-uppercase text-secondary font-weight-bolder">
            Price Breakdown
        </h6>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product Price</td>
                    <span v-if="price"
                        ><td>&#8358;{{ price.initial_price }}</td></span
                    >
                    <td v-else>&#8358;{{ final_price }}</td>
                </tr>
                <tr>
                    <td>Discounted Price</td>
                    <span v-if="price"
                        ><td>&#8358;{{ price.discounted_price }}</td></span
                    >
                    <td v-else>&#8358;{{ 0 }}</td>
                </tr>
                <tr>
                    <td>Payable Tax</td>
                    <span v-if="price"
                        ><td>&#8358;{{ price.tax }}</td></span
                    >
                    <td v-else>&#8358;{{ 0 }}</td>
                </tr>
                <tr>
                    <td><strong>Total Price</strong></td>
                    <span v-if="price"
                        ><td>&#8358;{{ price.total_price }}</td></span
                    >
                    <td v-else>
                        <strong>&#8358;{{ final_price }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["price", "final_price"]
};
</script>
