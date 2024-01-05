<template>
    <app-select
        v-bind="$attrs"
        v-on="$listeners"
        :items="hmos"
        item-text="name"
        item-value="code"
    />
</template>

<script>
import AppSelect from "../components/AppSelect.vue";
import orderService from "../services/order";
export default {
    name: "HmoSelect",
    components: {AppSelect},
    data() {
        return {
            loading: false,
            hmos: []
        }
    },
    methods: {
        getHmos() {
            this.loading = true;
            orderService.getHmos().then(hmos => {
                this.hmos = hmos.data
            }).finally(() => {
                this.loading = false;
            })
        }
    },

    mounted() {
        this.getHmos();
    }
}
</script>
