<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between" data-toggle="collapse"
                :data-target="`#collapse-${index}`" aria-expanded="true">
                <span class="title">
                    <pre>{{ batchName }}</pre>
                </span>
                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
            </div>
            <div :id="`collapse-${index}`" class="collapse" data-parent="#accordionExample">
                <div class="card-body">
                    <div class=" d-flex justify-content-between mb-3">
                        <div></div>
                        <div style="width: 200px;">
                            <input v-model="search" class="form-control form-control-sm" type="text"
                                placeholder="search...">
                        </div>
                    </div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Items Count</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Providers</th>
                                <th scope="col">Submitted On</th>
                                <th scope="col">Encounter Date</th>
                                <th scope="col">View order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in fitleredOrders">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ order.order_items.length }} items</td>
                                <td>{{ order.total }}</td>
                                <td>{{ order.provider }}</td>
                                <td>{{ order.submitted_at }}</td>
                                <td>{{ order.encounter_date }}</td>
                                <td>
                                    <button @click="sendOrderPayload(order)" href="javascript:void(0)"
                                        class="btn btn-warning btn-sm m-0">view</button>
                                    <button @click="processOrder(order)" href="javascript:void(0)"
                                        class="btn btn-primary btn-sm m-0" :disabled="order.is_processed === true">
                                        {{ order.is_processed === true ? 'processed' : 'process' }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        orders: {
            type: Array,
            required: true
        },
        batchName: {
            type: String,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            search: ''
        }
    },
    computed: {
        fitleredOrders() {
            return this.orders.filter((order) => {
                return order.provider.toLowerCase().includes(this.search.toLowerCase())
                    || order.encounter_date.toLowerCase().includes(this.search.toLowerCase())
                    || order.submitted_at.toLowerCase().includes(this.search.toLowerCase());
            })
        }
    },
    methods: {
        sendOrderPayload(order) {
            this.$emit('order-selected', order)
        },
        processOrder() {
            alert('order processing not available yet');
        }
    }
}
</script>
