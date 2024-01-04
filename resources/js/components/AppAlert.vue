<template>
    <div  :class="`alert alert-${type}`" role="alert">
        <slot />
    </div>
</template>

<script>
export default {
    name: "AppAlert",
    props: {
        type: String
    }
}
</script>
