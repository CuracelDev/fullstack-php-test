<template>


    <div class=" ">
        <div class="flex justify-center items-center my-auto">
            <div class="w-2/3">
                <div class="bg-white">
                    <span
                        class=" text-lg ml-2 my-2  pb-5 font-medium">Submit Orders</span>

                    <div class="card-body">

                        <div class="mt-5 p-5 shadow-sm relative ">

                            <div class=" py-2">
                                <div class="h-14 border-0 rounded-sm bg-gray-300 p-3 my-5">
                                    <h3 class="text-black">Details </h3>
                                </div>

                                <div class="flex flex-row space-x-1 my-3 mx-3">

                                    <div class="grow">
                                        <x-input
                                            name="providerName"
                                            label="Provider Name"
                                            :value="form.providerName"
                                            :errors="errors?.providerName"
                                            @input="(newItem) => {form.providerName = newItem}"
                                        >
                                        </x-input>

                                    </div>

                                    <div class="grow">

                                        <x-select
                                            name="hmo"
                                            label="Select HMO"
                                            valueKey="code"
                                            labelKey="name"
                                            :value="form.hmo"
                                            :options="form.hmoOptions"
                                            :errors="errors?.hmo"
                                            @input="(newItem) => {form.hmo = newItem}"
                                        >

                                        </x-select>
                                    </div>

                                    <div class="grow">
                                        <x-input
                                            type="date"
                                            name="encounterDate"
                                            label="Encounter Date"
                                            :value="form.encounterDate"
                                            :errors="errors?.encounterDate"
                                            @input="(newItem) => {form.encounterDate = newItem}"
                                        >
                                        </x-input>
                                    </div>

                                </div>
                            </div>


                            <div class="py-2 mb-24">
                                <div class="h-14 border-0 rounded-sm bg-gray-300 p-3 my-5">
                                    <h3 class="text-black">Orders ({{ form.orderItems.length }})</h3>
                                </div>

                                <div
                                    v-for="(orderItem,index) in form.orderItems" :key="index"
                                    class="flex flex-row space-x-1 my-3 mx-3 ">

                                    <div class="grow">
                                        <x-input
                                            name="name"
                                            label="Order Item"
                                            :value="orderItem.name"
                                            :errors="errors['orderItems.' + index + '.name']"
                                            @input="(newItem) => {orderItem.name = newItem}"
                                        >

                                        </x-input>
                                    </div>

                                    <div>
                                        <x-price-input
                                            name="unit_price"
                                            label="Unit Price"
                                            :value="orderItem.unit_price"
                                            :errors="errors['orderItems.' + index + '.unit_price']"
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
                                            :errors="errors['orderItems.' + index + '.quantity']"
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

                                <div class="absolute right-20 bottom-16 ">
                                    <x-price-input
                                        name="total"
                                        readonly='readonly'
                                        label="Total"
                                        classVal="w-32"
                                        :value="total"
                                        @input="(newItem) => {total = newItem}"
                                    ></x-price-input>
                                </div>


                            </div>


                            <div class="absolute left-8 bottom-2">
                                <button
                                    class="bg-blue-800 text-white rounded-md text-sm   px-3 py-2"
                                    @click="addMore()"
                                >
                                    <x-icons-orders></x-icons-orders>
                                    Add More
                                </button>
                            </div>

                            <div class="absolute right-9 bottom-2 z-10">
                                <button
                                    :disabled="submitting"
                                    :class="submitting ? 'bg-blue-100' : 'bg-blue-800 cursor-pointer'"
                                    class=" text-white w-56 rounded-md text-sm px-3 py-2"
                                        @click="submit()"
                                >
                                    <x-icons-submit></x-icons-submit>
                                    Submit
                                </button>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

        </div>

        <notifications position="bottom right"/>
    </div>
</template>

<script>

export default {
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
                ],
                providerName: "",
                hmoOptions: null,
                hmo: "HMO-A",
                encounterDate: ""
            },
            errors: {},
            submitting: false

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

            console.log(this.form.hmoOptions)
        },

        removeOrderItem(index) {
            if (this.form.orderItems.length > 1) {
                this.form.orderItems.splice(index, 1)
            }
        },
        submit() {
            this.submitting = true;
            this.errors = {};
            const headers = {
                'Content-Type': 'application/json'
            }

            axios.post("./api/order-items/submit", this.form, {
                headers: headers
            })
                .then(response => {
                    this.$notify({
                        title: "Success",
                        text:  response.data.message,
                        type: 'success',
                    })

                }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;

                }

                if (error.response.status === 429) {
                    this.$notify({
                        title: "Error",
                        text:  error.response.data.message,
                        type: 'error',
                    })
                }

                if(error.response.status === 500){
                    this.$notify({
                        title: "Error",
                        text: "An Error occurred",
                        type: 'error',
                    })
                }



            }).finally(() => {

                this.submitting = false;
            })
        },

        async getHmos() {
            const response = await fetch("./api/available-hmos");
            let data = await response.json();
            this.form.hmoOptions = data.result.data;
        }

    },

    watch: {
        form: {
            handler: function () {
                this.form.orderItems.forEach(orderItem => {
                    orderItem.sub_total = orderItem.unit_price * orderItem.quantity;
                });

            },
            deep: true
        },
    },
    computed: {
        total: {
            get() {
                return this.form.orderItems.reduce((sum, orderItem) => sum + orderItem.sub_total, 0);
            },
            set(val) {
                this.$emit('input', val);
            }

        }
    },
    mounted() {
        this.getHmos();
        console.log(this.form.hmoOptions)
    },
}
</script>
