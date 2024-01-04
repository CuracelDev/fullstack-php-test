<template>
    <div :class="`${$attrs.inline ? 'form-row my-2': 'form-group'}`" >
        <!-- Label -->
        <label :for="$attrs.id" v-if="label" :class="`${$attrs.inline ? 'col': ''}`">{{ label }}</label>
        <div :class="`${$attrs.inline ? 'col-auto': ''}`">
            <div class="small text-muted" v-if="helpText">{{helpText}}</div>
            <!-- Input group -->
            <div :class="`input-group input-group-merge ${$attrs.inline ? 'col': ''}`">
                <input class="form-control" v-bind="$attrs" @input="$emit('input', $event.target.value)">
            </div>
            <div v-if="errorString" class="text-danger" :class="`${$attrs.inline ? 'col-12': ''}`">
                {{ errorString }}
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: 'AppInput',
    props: {
        errors: null,
        label: String,
        helpText: String,
    },
    computed: {

        errorString() {
            if (typeof this.errors === 'string') return this.errors;
            if (!(this.errors && this.errors[this.$attrs.name])) return null;
            const error = this.errors[this.$attrs.name];
            return error.constructor === Array ? error[0] : error;
        },
    },
};
</script>
