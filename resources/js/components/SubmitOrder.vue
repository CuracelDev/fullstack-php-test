<!--<template>-->
<!--    <div class="container">-->
<!--        <div class="row justify-content-center">-->
<!--            <div class="col-md-8">-->
<!--                <div class="card">-->
<!--                    <div class="card-header">Submit An Order</div>-->

<!--                    <div class="card-body">-->
<!--                        Order details here-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--    export default {-->
<!--        mounted() {-->
<!--            console.log('Component mounted.')-->
<!--        }-->
<!--    }-->
<!--</script>-->

<template>
    <div class="bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
        </div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Create Order</h2>
        </div>
        <form action="#" @submit.prevent="" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-3">
                <div>
                    <label for="hmo-code" class="block text-sm font-semibold leading-6 text-gray-900">HMO Code</label>
                    <div class="mt-2.5">
                        <input
                            type="text"
                            placeholder="HMO Code"
                            v-model="data.hmo_code"
                            name="hmo-code"
                            id="hmo-code" autocomplete="given-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                        <InputError class="mt-2" :message="errorMessage(errors.hmo_code, 'hmo_code')" />
                    </div>
                </div>
                <div>
                    <label for="provider-code" class="block text-sm font-semibold leading-6 text-gray-900">Provider Code</label>
                    <div class="mt-2.5">
                        <input
                            type="text"
                            placeholder="Provider Code"
                            v-model="data.provider_code"
                            name="provider-code" id="provider-code" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                        <InputError class="mt-2" :message="errorMessage(errors.provider_code, 'provider_code')" />
                    </div>
                </div>
                <div>
                    <label for="encounter-date" class="block text-sm font-semibold leading-6 text-gray-900">Encounter Date</label>
                    <div class="mt-2.5">
                        <input type="date"
                               v-model="data.encounter_date"
                               name="encounter-date"
                               id="encounter-date"
                               autocomplete="family-name"
                               class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                        <InputError class="mt-2" :message="errorMessage(errors.encounter_date, 'encounter_date')" />
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-sm font-semibold leading-6 text-gray-900">Items</label>
                        <div v-for="(order, key) in data.items" :key="key" id="items" class="flex gap-4 items-center">
                            <div class="mt-2.5 sm:col-span-2">
                                <label :for="`item-name-${key}`" class="block text-sm font-semibold leading-6 text-gray-900">Item</label>
                                <input type="text" :id="`item-name-${key}`" placeholder="Order Name" v-model="order.name" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                                <InputError class="mt-2" :message="errorMessage(errors[`items.${key}.name`], 'encounter_date')" />
                            </div>
                            <div class="sm:col-span-2 mt-2.5">
                                <label :for="`item-unit-price-${key}`" class="block text-sm font-semibold leading-6 text-gray-900">Unit Price</label>
                                <input type="number" :id="`item-unit-price-${key}`" placeholder="Unit Price" v-model="order.unit_price" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                                <InputError class="mt-2" :message="errorMessage(errors[`items.${key}.unit_price`], 'encounter_date')" />
                            </div>
                            <div class="sm:col-span-2 mt-2.5">
                                <label :for="`item-qty-${key}`" class="block text-sm font-semibold leading-6 text-gray-900">Qty</label>
                                <input type="number" :id="`item-qty-${key}`" placeholder="Quantity" v-model="order.quantity" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />

                                <InputError class="mt-2" :message="errorMessage(errors[`items.${key}.quantity`], 'encounter_date')" />
                            </div>
                            <div class="sm:col-span-2 mt-2.5">
                                <label :for="`item-sub-total-${key}`" class="block text-sm font-semibold leading-6 text-gray-900">Sub Total</label>
                                <input type="number" :id="`item-sub-total-${key}`" readonly placeholder="Sub Total" :value="calculateSubTotal(order.quantity,order.unit_price)" autocomplete="organization" class="block contrast-75 w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                            <div type="button" @click="removeItem(key)" class="border px-3 py-0 rounded-lg sm:col-span-2 mt-6 font-bolder cursor-pointer">
                                -
                            </div>
                        </div>


                    <div class="flex gap-4 items-control">
                        <div class="sm:col-span-3">
                            <button type="button" @click="addItem" class="mt-2 py-2 px-4 text-base font-medium text-white shadow-sm hover:800 rounded-md border border-transparent bg-indigo-700">
                                Add
                            </button>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-sm font-semibold leading-6 text-gray-900">Order Summary</label>

                    <table class="table-auto">
                            <thead>

                            </thead>
                            <tbody>
                                <tr class="mt-2.5">
                                    <td class="mr-10">Total Quantity</td>
                                    <td>{{ data.items.reduce((total, item) => total + item.quantity, 0) }}</td>
                                </tr>
                                <tr class="mt-2.5">
                                    <td class="mr-10">Total Item</td>
                                    <td>{{ data.items.length }}</td>
                                </tr>
                                <tr class="mt-2.5">
                                    <td class="mr-10">Price Total</td>
                                    <td>{{ data.items.reduce((total, item) => total + (item.quantity * item.unit_price), 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="mt-10">
                <button type="button" @click="submitOrderRequest"  class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit Order</button>
            </div>
        </form>

        <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="relative z-10" @close="open = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                                        </div>
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Order Added</DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">Order Has Successfully Been Added!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Ok</button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>

import { reactive } from "vue";
import InputError from "@/components/InputError.vue";
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { CheckIcon } from '@heroicons/vue/24/outline'

const open = ref(false)
const props = defineProps({
    errors: {
        required: false,
        type: Object,
    }
})

const errors = reactive({});

const errorMessage = (error, objectKey) => {
    if (error && Object.values(error).length > 0) {
        return Object.values(error)[0]
    }

    return false
}

const data = reactive((() => {
    return {
        hmo_code: '',
        provider_code: '',
        encounter_date: (new Date()).toISOString().split('T')[0],
        sent_date: (new Date()).toISOString(),
        items: [
            {
                name: '',
                quantity: 1,
                unit_price: 1
            }
        ]
    }
})())

const addItem = () => {
    data.items.push({
        name: '',
        quantity: 1,
        unit_price: 1,
    })
}

const calculateSubTotal = (quantity, unitPrice) => {
    return quantity * unitPrice;
}

const removeItem = (index) => {
    if (data.items.length > 1) {
        data.items.splice(index, 1);
    }
}

const submitOrderRequest = async () => {

    Object.assign(errors, {})

    const request = await axios.post(route('api.order.store'), data)
        .catch(error => {
            Object.assign(errors, error?.response?.data?.errors)
        });


    if (request?.data.status) {
        Object.assign(data, {
            hmo_code: '',
            provider_code: '',
            encounter_date: (new Date()).toISOString().split('T')[0],
            sent_date: (new Date()).toISOString(),
            items: [
                {
                    name: '',
                    quantity: 1,
                    unit_price: 1
                }
            ]
        })

        open.value = true;
    }
}



</script>
<style>

    /*.items-control {*/
    /*    margin: ;*/
    /*}*/

</style>
