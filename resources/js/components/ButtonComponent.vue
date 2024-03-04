<template>
    <div>
        hello word
    </div>
</template>

<script>
import { http } from '../utils/http';

export default {
    methods: {
        async getUser() {
            await http.get('/user');
        }
    },
    mounted() {
        this.getUser()
    }
}
</script>
