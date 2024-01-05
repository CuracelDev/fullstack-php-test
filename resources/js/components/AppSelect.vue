<template>
    <app-input :errors="errors" :label="label" :help-text="helpText" v-bind="$attrs">
        <select class="form-control" v-bind="$attrs" v-model="selected">
            <option
                v-for="(item, i) in items"
                :key="i"
                :value="item[itemValue]">
                {{ item[itemText] }}
            </option>
        </select>
    </app-input>
</template>

<script>
import AppInput from "./AppInput.vue";

export default {
    name: 'AppSelect',
    components: {AppInput},
    data() {
        return {
            selected: null
        }
    },
    props: {
        value: null,
        errors: null,
        label: String,
        helpText: String,
        items: Array,
        itemValue: {
            default: "id"
        },
        itemText: {
            default: "label"
        }
    },
    watch: {
        value: {
            immediate: true,
            handler(v) {
                this.selected = v;
            }
        },
        selected: {
            immediate: true,
            handler(item) {
                this.$emit("input", item)
            }
        }
    }
};
</script>
