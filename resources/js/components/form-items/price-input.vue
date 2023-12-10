<script>
export default {
    name: "x-price-input",
    props: {
        'name': {type: String},
        'value': {type: [String, Number]},
        'label': {type: String},
        'classValue': {type: String},
        'readonly': {type: String}
    },
    computed: {
        inputVal: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    }
}
</script>

<template>
    <div>
        <label for="price"
               class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</label>
        <div class="relative  rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm">&#8358;</span>
            </div>
            <input
                type="text"
                v-model="inputVal"
                :name="name"
                :readonly="readonly"
                :class="classValue"
                class=" w-full rounded-md border-0 py-1.5 pl-7 text-gray-900 ring-1
                    ring-inset ring-blue-300 placeholder:text-gray-400  focus:ring-inset
                    focus:ring-blue-200 sm:text-sm sm:leading-6"
                placeholder="0.00">
        </div>
    </div>
</template>
