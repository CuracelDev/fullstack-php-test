<template>


    <div class=" ">
        <div class="flex justify-center items-center my-auto">
            <div class="w-2/3">
                <div class="shadow-md bg-white">
                    <span class=" text-lg ml-2 my-2  pb-5 font-medium">Submit Orders</span>
                    <div class="card-header"></div>

                    <div class="card-body">
                        <div>
                            <div class="mt-5 p-5">

                                <div
                                    v-for="(orderItem,index) in form.orderItems" :key="index"
                                    class="flex flex-row space-x-1 my-3">

                                    <div class="grow">
                                        <x-input
                                            name="order_item_name"
                                            label="Order Item"
                                            :value="orderItem.name"
                                            @input="(newItem) => {orderItem.name = newItem}"
                                        >

                                        </x-input>
                                    </div>

                                    <div>
                                        <x-price-input
                                            name="unit_price"
                                            label="Unit Price"
                                            :value="orderItem.unit_price"
                                            @input="(newItem) => {orderItem.unit_price = newItem}"
                                        >
                                        </x-price-input>
                                    </div>

                                    <div>
                                        <x-input
                                            name="quantity"
                                            min="1"
                                            type="number"
                                            label="Quantity"
                                            classValue="w-24"
                                            placeholder="9"
                                            :value="orderItem.quantity"
                                            @input="(newItem) => {orderItem.quantity = newItem}"
                                        ></x-input>
                                    </div>

                                    <div>
                                        <x-price-input
                                            name="sub_total"
                                            readonly='readonly'
                                            label="Sub Total"
                                            :value="orderItem.sub_total"
                                            @input="(newItem) => {orderItem.sub_total = newItem}"
                                        >
                                        </x-price-input>
                                    </div>

                                    <div>
                                        <button
                                            @click="removeOrderItem(index)"
                                            class="bg-blue-800 text-white rounded-md text-sm mt-5 px-3 py-2"
                                        >
                                            <x-icons-delete></x-icons-delete>
                                        </button>
                                    </div>

                                </div>


                                <div class="">
                                    <button
                                        class="bg-blue-800 text-white rounded-md text-sm  my-2  px-3 py-2"
                                        @click="addMore()"
                                    >
                                        <x-icons-orders></x-icons-orders>
                                        Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {

    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            form: {
                orderItems: [
                    {
                        name: "",
                        unit_price: 0,
                        quantity: 0,
                        sub_total: 0,
                    }
                ]
            }
        }
    },
    methods: {
        addMore() {
            this.form.orderItems.push({
                name: "",
                unit_price: 0,
                quantity: 0,
                sub_total: 0,
            })

            console.log(this.form.orderItems)
        },

        removeOrderItem(index) {
            this.form.orderItems.splice(index, 1)
        },

    },

    watch: {
        form: {
          handler: function () {
              this.form.orderItems.forEach(orderItem => {
                  orderItem.sub_total =  orderItem.unit_price * orderItem.quantity
              });
          },
            deep: true
        },
    }
}
</script>
