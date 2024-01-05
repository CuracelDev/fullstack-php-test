<template>
    <button class="btn" :disabled="loading" v-on="$listeners">
        <span class="spinner-border spinner-border-sm" role="status" v-if="loading">
            <span class="sr-only">Loading...</span>
        </span>
        <span><slot/></span>
    </button>
</template>

<script>
export default {
    name: "AppButton",
    props: ['loading'],
}
</script>
