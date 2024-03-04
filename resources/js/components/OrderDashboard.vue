<template>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-10">
                <FilterComponent @filter="handleFilter" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="loading">loading...</div>
                <div v-else-if="batchOrders.length === 0">
                    <h2>No order available for the selected month or year. </h2>
                    <p>kindly change the filter parameters to get orders</p>
                </div>
                <div v-else class="accordion" id="accordionExample">
                    <OrderList v-for="(orders, batchName, index) in batchOrders" :key="index" :orders="orders"
                        :batchName="batchName" :index="index" @order-selected="handleOrderSelection" />
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Selected Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="selectedOrder">
                        <div>
                            HMO: {{ selectedOrder.hmo }} <br>
                            Provider: {{ selectedOrder.provider }} <br>
                            Submission Date: {{ selectedOrder.submitted_at }} <br>
                            Encounter Date: {{ selectedOrder.encounter_date }} <br>
                        </div>
                        <h4 class="my-3">Order Items</h4>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit price</th>
                                    <th scope="col">sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in selectedOrder.order_items" :key="index">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.unit_price }}</td>
                                    <td>{{ item.quantity }}</td>
                                    <td>{{ item.sub_total }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between" style="width: 100%;">
                            <div></div>
                            <h4 class="float-right">Total: {{ selectedOrder.total }}</h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { http } from '../utils/http';
import OrderList from './OrderList.vue';
import FilterComponent from './FilterComponent.vue';

export default {
    components: {
        OrderList,
        FilterComponent
    },
    data() {
        return {
            filterParams: {
                filter_by: 'encounter_date',
                month: 'February',
                year: 2024
            },
            batchOrders: [],
            selectedOrder: null,
            loading: false
        }
    },
    computed: {
        queryString() {
            return new URLSearchParams(this.filterParams).toString();
        }
    },
    methods: {
        async getOrders() {
            this.loading = true;

            this.batchOrders = (await http.get(`/orders?${this.queryString}`)).data;

            this.loading = false
        },
        handleOrderSelection(order) {
            this.selectedOrder = order;
            $('#exampleModal').modal('show');
        },
        handleFilter(filterObject) {
            this.filterParams = filterObject;

            this.getOrders();
        }
    }
}
</script>
