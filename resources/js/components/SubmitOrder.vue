<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        <form id="order-form" @submit.prevent="submit">
                            <div class="form-group">
                                <label for="provider_name">Name</label>
                                <input class="form-control" id="provider_name" name="provider_name"
                                    placeholder="Your full name" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="hmo_code">HMO Code</label>
                                    <input class="form-control" id="hmo_code" name="hmo_code" placeholder="code of HMO"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="encounter_date">Encounter Date</label>
                                    <input type="date" class="form-control" name="encounter_date" id="encounter_date"
                                        :max="new Date().toISOString().substring(0, 10)" required>
                                </div>
                            </div>
                            <table class="table table-striped items">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>SubTotal</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item, index of items" :key="index">
                                        <td><input v-model="item.name" required></td>
                                        <td><input type="number" step="0.01" min="0.01" v-model="item.unit_price" required>
                                        </td>
                                        <td><input type="number" v-model="item.quantity" step="1" min="1" required></td>
                                        <td><input class="sum" :value="subTotal(item.unit_price, item.quantity)" disabled>
                                        </td>
                                        <td><button type="button" class="remove_btn" title="Remove this row"
                                                @click="removeItem(index)">&mdash;</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" class="add_btn" title="Add new item"
                                                @click="addItem()">+</button></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td><input class="sum" :value="total(items)" disabled></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary col-5 mx-auto d-block" :disabled="submitDisabled">Submit</button>
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
            items: [{ name: undefined, unit_price: undefined, quantity: 1 }],
            form: null,
            submitDisabled: false
        };
    },
    mounted() {
        this.form = document.getElementById("order-form");
    },
    methods: {
        addItem() {
            this.items.push({ name: undefined, unit_price: undefined, quantity: 1 });
        },
        removeItem(index) {
            if (this.items.length == 1) return;
            this.items.splice(index, 1);
        },
        subTotal(unitPrice, quantity) {
            const total = unitPrice * quantity;
            return !isNaN(total) ? total.toFixed(2) : undefined;
        },
        total(items) {
            let total = 0;
            for (let item of items) total += Number(this.subTotal(item.unit_price, item.quantity));
            return !isNaN(total) ? total.toFixed(2) : "";
        },
        async submit() {
            this.submitDisabled = true;
            const formData = new FormData(this.form);
            const reqBody = {items: this.items};
            formData.forEach((value, key) => reqBody[key] = value);
            const response = await this.post("/order", reqBody);
            this.submitDisabled = false;
            if (response.status == 200) {
                alert("Order submitted successfuly");
                this.items = [{ name: undefined, unit_price: undefined, quantity: 1 }]; // clear all items
            } else alert("Sorry, order could not be posted. Please try again");
        },
        post(path, body) {
            return fetch("http://localhost:8000/api" + path, { // change this line to run on your server
                method: "POST", headers: {"Content-Type": "application/json"}, body: JSON.stringify(body)
            });
        }

    }
}
</script>
<style scoped>
.add_btn,
.remove_btn {
    border: none;
    outline: none;
    background-color: lightgray;
    min-width: 40px;
    min-height: 28px;
}

.add_btn:hover {
    border: 2px lightgreen solid;
}

.remove_btn:hover {
    border: 2px lightcoral solid;
}

.items input {
    width: 100%;
}

.items td {
    width: 15%;
    min-width: 100px;
}

.items td:first-child {
    width: 35%;
    min-width: 200px;
}

/* .sum {
    appearance: textfield;
} */
</style>