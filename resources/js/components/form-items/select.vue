<script>
export default {
    name: "x-select",
    props: {
        'name': {type: String},
        'value': {type: [String, Number]},
        'label': {type: String},
        'classValue': {type: String},
        'options': {type: Array}

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
        <select
            v-model="inputVal"
            :name="name"
            class=" w-full rounded-md border-0 py-3 pl-2  text-gray-900 ring-1
                    ring-inset ring-blue-300 placeholder:text-gray-400  focus:ring-inset
                    focus:ring-blue-200 sm:text-sm sm:leading-6"
            :class="classValue"

            >
            <option v-for="(option, index) in options" :value="option">
                {{option}}
            </option>
        </select>
    </div>
</template>

<style scoped>

</style>
