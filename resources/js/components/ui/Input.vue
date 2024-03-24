<template>
    <input
        :type="type"
        class="form-control"
        :max="maxDate"
        :placeholder="placeholder"
        :value="value"
        @input="handleInput"
    >
</template>

<script>
import {formatDate} from "../../utils";

export default {
    name: "Input",
    props:{
        type:String,
        value: [String, Number, Object],
        placeholder:String
    },
    data(){
        return{
            maxDate: formatDate(new Date())
        }
    },
    methods: {
        handleInput(e) {
            this.$emit("input", e.target.value);
        },
    },
}
</script>

<style scoped>

</style>
