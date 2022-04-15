<template>
    <div :class="['alert alert-dismissible fade show', `alert-${type}`]" role="alert">
        {{ text }}
    </div>
</template>

<script>
export default {
    props : {
        type: String,
        text: String
    }
}
</script>