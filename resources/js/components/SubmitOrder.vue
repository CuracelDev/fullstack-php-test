<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">

                        <div class="alert alert-success alert-dismissible fade show" role="alert" v-show="showSuccessMessage">
                            <span>Order submitted successfully!</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-danger" role="alert" v-show="showErrorMessage">
                            <strong>Error!</strong> {{ errorMessage }}.
                        </div>

                        <form @submit.prevent="submitOrder">
                            <div class="form-group">
                                <label class="mt-2" for="name">Name (Your short provider name)</label>
                                <input v-model="name" required class="form-control" type="text" name="name" placeholder="Name" id="name">
                            </div>
                            <div class="form-group">
                                <label class="mt-2" for="hmo">HMO</label>
                                <select v-model="selectedHmo" id="hmo" required class="form-control">
                                    <option value="" disabled>Select HMO</option>
                                    <option v-for="hmo in hmos" :key="hmo.code" :value="hmo.code">{{ hmo.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mt-2" for="encounterDate">Encounter Date</label>
                                <input v-model="encounterDate" required class="form-control" type="date" id="encounterDate" :max="new Date().toLocaleDateString('en-CA')">
                            </div>
                            <hr>
                            <SingleOrderItem
                                v-for="item in items"
                                :key="item.id"
                                :singleItem="item"
                                @deleteItem="deleteItem"
                                @updateItem="updateItem"
                            ></SingleOrderItem>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="name">Add</label>
                                    <button class="form-control" @click="addItem" type="button">+</button>
                                </div>
                                <div class="form-group col-md-7">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total">Total</label>
                                    <input readonly required class="form-control" :value="total" placeholder="Total" id="total">
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark col-md-4" :disabled="submitBtnLoading">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SingleOrderItem from './SingleOrderItem.vue'

export default {
    props: ["hmos"],
    data() {
        return {
            name: "",
            selectedHmo: "",
            encounterDate: "",
            items: [{ id: 1, item: null, price: null, quantity: null }],
            itemCounter: 1,
            submitBtnLoading: false,
            errorMessage: null,
            showErrorMessage: false,
            showSuccessMessage: false
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        addItem() {
            const newItem = { id: ++this.itemCounter, item: null, price: null, quantity: null };
            this.items.push(newItem);
        },
        deleteItem(itemId) {
            if (this.items.length == 1) {
                return;
            }

            this.items = this.items.filter((item) => item.id !== itemId);
        },
        updateItem(itemId, updatedItem) {
            this.items = this.items.map(item => {
                return item.id === itemId ? updatedItem : item;
            });
        },
        submitOrder() {
            this.submitBtnLoading = true;
            const payload = {
                name: this.name,
                hmo: this.selectedHmo,
                encounter_date: this.encounterDate,
                items: this.items,
            };
            window.axios.post("/api/orders", payload)
                .then(res => {
                this.submitBtnLoading = false;
                this.showErrorMessage = false;

                //reset all fields
                this.name = "";
                this.selectedHmo = "";
                this.encounterDate = "";
                this.items = [{ id: ++this.itemCounter, item: null, price: null, quantity: null }];

                this.showSuccessMessage = true;
                setTimeout(() => this.showSuccessMessage = false, 4000);
            })
                .catch((err) => {
                this.submitBtnLoading = false;
                this.errorMessage = err?.response?.data?.message ?? "An error occurred, please try again.";
                this.showErrorMessage = true;
            });
        }
    },
    computed: {
        total() {
            return this.items.reduce((acc, currentItem) => (acc + (currentItem.price * currentItem.quantity)), 0)
        }
    },
    components: { SingleOrderItem }
}
</script>
