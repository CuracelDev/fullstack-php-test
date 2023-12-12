<script>
export default {
    name: "x-input",
    props: {
        'name': {type: String},
        'value': {type: [String, Number]},
        'label': {type: String},
        'classValue': {type: String},
        'type': {type: String, default: "text"},
        'placeholder': {type: String},
        'min': {type:[Number, String] , default: 0},
        'errors': {type: [Array]},
        'id' : {type: String, default: ''}
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
        <label for="price" class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</label>
        <input
            :type="type"
            v-model="inputVal"
            :name="name"
            class=" w-full rounded-md border-0 py-2.5 pl-2  text-gray-900 ring-1
                    ring-inset ring-blue-300 placeholder:text-gray-400  focus:ring-inset
                    focus:ring-blue-200 sm:text-sm sm:leading-6"
            :class="classValue"
            :min="min"
            :id="id"
            :placeholder="placeholder">

        <span class="block text-red-600 text-xs w-32" v-if="errors">{{ errors[0] }}</span>
    </div>

</template>

<style scoped>

</style>
