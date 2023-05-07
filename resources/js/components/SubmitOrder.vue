<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        <form @submit.prevent="handleSubmit" class="row" method="POST">
                            <div class="col-md-4 form-group">
                                <input class="form-control" type="text" v-model="formData.code" placeholder="HMO Code">
                            </div>
                            <div class="col-md-4 form-group">
                                <input class="form-control" type="text" v-model="formData.name" placeholder="HMO Name">
                            </div>
                            <div class="col-md-4 form-group">
                                <input class="form-control" type="date" v-model="formData.encounter_date">
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-md-4">Item</th>
                                            <th class="col-md-2">Unit Price</th>
                                            <th class="col-md-2">Qty</th>
                                            <th class="col-md-3">Sub Total</th>
                                            <th class="col-md-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in formData.items" :key="index">
                                            <td>
                                                <input type="text" class="form-control col-md-12" @input="handleChange($event, index)" :value="item.title" name="title">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control col-md-12" @input="handleChange($event, index)" :value="item.unit_price" name="unit_price">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control col-md-12" @input="handleChange($event, index)" :value="item.quantity" name="quantity">
                                            </td>
                                            <td>
                                                <input type="number" readonly="readonly" :class="`form-control col-md-12 subtotal-${index}`" :value="item.unit_price * item.quantity">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" @click.prevent="removeItem(index)">-</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <button class="btn btn-sm btn-info text-white" @click.prevent="addItem()">+</button>
                                            </td>
                                            <td></td>
                                            <td class="align-middle">Total</td>
                                            <td>
                                                <input type="number" readonly="readonly" class="form-control col-md-12 total" :value="totalPrice">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-info mx-auto text-white">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formData: {
                    code: '',
                    name: '',
                    encounter_date: '',
                    items: [
                        {
                            title: '',
                            unit_price: '',
                            quantity: 1
                        }
                    ]
                }
            }
        },
        computed: {
            totalPrice: function () {
                return this.formData.items.reduce((acc, item) => acc + (item.unit_price * item.quantity), 0)
            }
        },
        methods: {
            handleChange(evt, index) {
                this.formData.items.splice(index, 1, {...this.formData.items[index], [evt.target.name]: evt.target.value})
            },
            addItem() {
                let defaultItem = {title: '', unit_price: '', quantity: 1}
                this.formData.items.push(defaultItem)
            },
            handleSubmit() {
                const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
                console.log(csrfToken)

                let currentUrl = window.location.origin
                const response = fetch(`${currentUrl}/hmos/batch-data`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": csrfToken
                    },
                    body: JSON.stringify(this.formData)
                })

                return response.then((data) => {
                    return data.json();
                })
            },
            removeItem(index) {
                this.formData.items.splice(index, 1)
            },
        }
    }
</script>
