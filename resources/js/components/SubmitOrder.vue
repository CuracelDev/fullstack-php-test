<template>
    <div class="container">

        <form>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="hmocode">HMO Code</label>
                        <input id="hmocode" v-model="hmo.code" :name="hmo.code" class="form-control" type="text">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="hmoname">HMO Name</label>
                        <input id="hmoname" v-model="hmo.name" :name="hmo.name" class="form-control" type="text">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="hmoemail">HMO Email</label>
                        <input id="hmoemail" v-model="hmo.email" :name="hmo.email" class="form-control" type="email">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Encounter Date</label>
                        <date-picker v-model="edate" :config="date_options"></date-picker>
                    </div>
                </div>
            </div>


            <table class="table table-borderless">
                <thead>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(order, index) in orders" :key="index">
                    <td>
                        <input v-model="order.item" :name="`orders[${index}][item]`" class="form-control"
                               type="text">
                    </td>
                    <td>
                        <input v-model="order.price" :name="`orders[${index}][price]`" class="form-control"
                               type="number">
                    </td>
                    <td>
                        <input v-model="order.qty" :name="`orders[${index}][qty]`" class="form-control"
                               type="number">
                    </td>
                    <td>
                        <input v-model="order.subtotal" :name="`orders[${index}][subtotal]`" class="form-control"
                               readonly type="number">
                    </td>
                    <td>
                        <button class="btn btn-secondary" type="button" @click="removeItem(index)">-</button>
                    </td>
                </tr>


                <tr>
                    <td>
                        <button class="btn btn-secondary" type="button" @click="addItem">+</button>
                    </td>
                    <td>
                    </td>
                    <td>
                        Total
                    </td>
                    <td>
                        <input v-model="total" :name="total" class="form-control" readonly type="number">
                    </td>
                    <td>
                    </td>
                </tr>

                </tbody>
            </table>


            <hr>

            <div v-show="orders.length > 0" class="form-group">
                <button class="btn btn-primary" type="button" @click="submit">Submit</button>
            </div>
        </form>


    </div>

</template>

<script>
import datePicker from "vue-bootstrap-datetimepicker";
import "@fortawesome/fontawesome-free/css/all.css";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

export default {
    name: "SubmitOrder",
    components: {
        datePicker
    },
    mounted() {
        console.log('Component mounted.');
        this.resetForm();
    },
    data() {
        return {
            edate : new Date,
            hmo: {
                code: 'HMO-A',
                name: 'HMO A',
                email: 'hmoa@site.com',
            },
            orders: [
                {
                    item: "Batch 1",
                    price: 200,
                    qty: 4,
                    subtotal: 0
                },
                {
                    item: "Batch 2",
                    price: 300,
                    qty: 5,
                    subtotal: 0
                },
            ],
            date_options: {
                format: "DD/MM/YYYY h:m:s a",
                useCurrent: false,
                icons: {
                    time: "far fa-clock",
                    date: "far fa-calendar",
                    up: "fas fa-arrow-up",
                    down: "fas fa-arrow-down",
                    previous: "fas fa-chevron-left",
                    next: "fas fa-chevron-right",
                    today: "fas fa-calendar-check",
                    clear: "far fa-trash-alt",
                    close: "far fa-times-circle",
                },
            },
        };
    },
    watch: {
        orders: {
            handler: function (newval, oldval) {
                this.orders.forEach(p => {
                    p.subtotal = p.price * p.qty;
                });
            }, deep: true,
            immediate: true
        }
    },
    computed: {
        total: function () {
            return this.orders.reduce(function (total, order) {
                return total + Number(order.subtotal);
            }, 0);
        },
        formData: function () {
            return {
                edate: this.edate,
                hmo: this.hmo,
                orders: this.orders,
                total: this.total,
            }
        },
    },
    methods: {
        addItem() {
            this.orders.push({
                item: 0,
                price: 0,
                qty: 0,
                subtotal: 0
            })
        },
        removeItem(index) {
            this.orders.splice(index, 1);
        },
        resetForm() {
            return;
           this.edate = '';
           this.hmo = {};
           this.orders=[];
        },

        submit() {
            const self = this;
            axios.post('/api/orderSubmit', this.formData)
                .then(function (response) {
                    self.resetForm();
                    alert(response.data.message);
                })
                .catch(function (error) {
                    alert("An error occurred while sending your data");
                });
        }
    }
}
</script>

<style>
.table th, .table td {
    padding: 0.25rem;
    vertical-align: top;
}
</style>
