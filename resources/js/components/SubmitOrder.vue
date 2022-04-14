<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit An Order</div>

                    <div class="card-body">
                        <div>
                            <div class="row align-items-end ju">
                                <div class="col">
                                    <label class="form-label">Item</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Unit Price</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Qty</label>
                                </div>
                                <div class="col">
                                    <label class="form-label">Sub Total</label>
                                </div>
                                <div class="col"></div>
                            </div>
                            <div
                                v-for="(item, idx) in items"
                                :key="idx"
                                class="row align-items-end mb-3"
                            >
                                <div class="col">
                                    <input class="form-control" v-model="item.item" />
                                </div>
                                <div class="col">
                                    <input class="form-control" v-model="item.unit" />
                                </div>
                                <div class="col">
                                    <input class="form-control" v-model="item.qty" />
                                </div>
                                <div class="col">
                                    <input disabled v-model="item.subtotal" class="form-control" />
                                </div>

                                <div class="col">
                                    <button type="button" class="btn btn-danger" @click="handleRemove">
                                        -
                                    </button>
                                </div>
                            </div>
                            <hr class="mt-5" />
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="mt-2 btn btn-success" @click="handleAdd">
                                        +
                                    </button>
                                </div>

                                <div class="col-4 d-flex align-items-center">
                                    <label for="total" class="form-label mr-2">Total</label>
                                    <input :value="totalOrders" id="total" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row g-3" style="margin-top: 15px">
                            <div class="col-md-4">
                                <label for="provider" class="form-label">Provider</label>
                                <input type="text" class="form-control" id="provider" v-model="provider" required>
                            </div>
                            <div class="col-md-4">
                                <label for="hmo" class="form-label">HMO</label>
                                <select type="text" class="form-control form-select" id="hmo" v-model="hmo" >
                                    <option selected disabled value="">Choose...</option>
                                    <option v-for="hmo in hmos" :value="hmo.code">{{hmo.name}}</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="encounter_date" class="form-label">Encounter Date</label>
                                <input type="date" class="form-control" id="encounter_date" v-model="encounter_date" required>
                            </div>

                            <div class="col-md-12" style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
          totalOrders() {
              return this.items.reduce((total, { subtotal }) => subtotal + total, 0);
          }
        },
        data() {
            return {
                items: [
                    {
                        item: "",
                        unit: 0,
                        qty: 0,
                        subtotal: 20
                    },
                ],
                provider: '',
                encounter_date: '',
                hmo: '',
                hmos: [],
                total: 0
            }
        },
        methods: {
            handleAdd() {
                this.items = [
                    ...this.items,
                    {
                        item: "",
                        unit: "",
                        qty: "",
                        subtotal: 0
                    },
                ];
            },

            handleRemove(idx) {
                this.items.splice(idx, 1);
            },

            calculateSubtotal({qty, unit}) {
                return unit * qty;
            }
        },
        async mounted() {
            const response = await fetch('/api/hmos')
            const { data } = await response.json()
            this.hmos = data
        }
    }
</script>
