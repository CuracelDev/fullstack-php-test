<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        Counter : {{ counter }}
                    </div>
                    <button class="btn btn-primary" @click="increment">increment</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { http } from '../utils/http';

export default {
    data() {
        return {
            counter: 0
        }
    },
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
