<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, reactive, ref } from 'vue';
import axios from 'axios';
import { QuestionMarkCircleIcon } from '@heroicons/vue/20/solid';

// Data
const currentDate = computed(() => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();

    return `${year}-${month < 10 ? `0${month}` : month}-${day < 10 ? `0${day}` : day}`;
});
const getInitialFormData = () => {
    return {
        hmo_code: '',
        provider_code: '',
        encounter_date: null,
        sent_date: currentDate,
        items: [
            {
                name: '',
                unitPrice: 0,
                quantity: 1,
                subtotal: 0
            }
        ]
    };
};
const formData = reactive(getInitialFormData());
const isDisabled = ref(true);
const errorBag = ref('');

// Computed properties
const totalQuantity = computed(() => {
    return formData.items.reduce((total, item) => total + item.quantity, 0);
});

const totalAmount = computed(() => {
    return formData.items.reduce((total, item) => total + item.subtotal, 0);
});

// Methods
const recalculateSubtotal = (item) => {
    return calculateSubtotal(item);
};

const removeOrderItem = (index) => {
    if (formData.items.length === 1) return;
    formData.items.splice(index, 1);
};

const addOrderItem = () => {
    formData.items.push({ name: '', unitPrice: 0, quantity: 1, subtotal: 0 });
};

const calculateSubtotal = (orderItem) => {
    orderItem.subtotal = orderItem.unitPrice * orderItem.quantity;
};

const currencyFormatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'NGN',
});

const resetFormData = () => {
    Object.assign(formData, getInitialFormData());
    errorBag.value = ''
};

const submitForm = () => {
    axios.post('/api/orders', formData)
        .then(response => {
            alert('Order submitted successfully');
            resetFormData();
        })
        .catch(error => {
            console.error('Error submitting order');
            console.error(error.response);
            errorBag.value = error.response.data.message;
        });
};

const moreInfo = (type) => {
    alert(`To get a valid ${type} code, run your seeder if you haven't, then go to the providers table and copy the code`)

}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Create Order</h1>
                <div class="text-red-500 mt-3" v-if="errorBag">
                    <p>Validation Error</p>
                    <p class="mt-2">{{errorBag}}</p>
                </div>
                <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <div class="flex gap-4 w-full grid-cols-12 mb-4">
                            <div class="flex-1">
                                <label for="city" class="flex text-sm font-medium leading-6 text-gray-900">
                                    Provider Code
                                    <QuestionMarkCircleIcon @click="moreInfo('providers')" class="h-5 w-5 ml-2 text-gray-500 cursor-pointer " aria-hidden="true" />
                                </label>
                                <div class="mt-2">
                                    <input type="text" v-model="formData.provider_code" placeholder="Provider Code" required autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 w-full" />
                                </div>
                            </div>

                            <div class="flex-1">
                                <label for="city" class="flex text-sm font-medium leading-6 text-gray-900">
                                    HMO Code
                                    <QuestionMarkCircleIcon @click="moreInfo('hmos')" class="h-5 w-5 ml-2 text-gray-500 cursor-pointer " aria-hidden="true" />
                                </label>
                                <div class="mt-2">
                                    <input type="text" v-model="formData.hmo_code" placeholder="HMO Code" required autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 w-full" />
                                </div>
                            </div>

                            <div class="flex-1">
                                <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Encounter Date</label>
                                <div class="mt-2">
                                    <input type="date" v-model="formData.encounter_date" required autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 w-full" />
                                </div>
                            </div>
                        </div>


                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>
                        <div v-for="(item, index) in formData.items" :key="index" class="flex gap-4 items-center">
                            <div class="sm:col-span-2">
                                <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Item</label>
                                <div class="mt-2">
                                    <input type="text" v-model="item.name" name="city" id="city" required autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Unit Price</label>
                                <div class="mt-2">
                                    <input type="number" @input="calculateSubtotal(item)" v-model="item.unitPrice" required name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Qty</label>
                                <div class="mt-2">
                                    <input type="number" @input="calculateSubtotal(item)" v-model="item.quantity" required name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" />
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Sub Total</label>
                                <div class="mt-2">
                                    <input type="text" @input="recalculateSubtotal(item, index)" v-model="item.subtotal" :disabled="isDisabled" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" />
                                </div>
                            </div>
                            <div type="button" @click="removeOrderItem(index)" class="border px-3 py-0 rounded-lg sm:col-span-2 mt-6 font-bolder cursor-pointer">
                                    -
                            </div>
                        </div>
                        <div class="mt-6 text-right">
                            <button type="button" @click="addOrderItem" class="rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Add</button>
                        </div>
                    </section>


                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading" class="sticky top-0 mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Total Quantity</dt>
                                <dd class="text-sm font-medium text-gray-900">{{totalQuantity}}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm text-gray-600">
                                    <span>Total Items</span>
                                    <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                        <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ formData.items.length }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900"> {{ currencyFormatter.format(totalAmount) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <button @click="submitForm" type="button" class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Place Order 🥳</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
