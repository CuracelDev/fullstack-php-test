<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                <div
                    class="col"
                    v-for="(product, column) in productsInRow(row)"
                    :key="'row' + row + column"
                >
                    <product-item
                        :title="product.title"
                        :content="product.content"
                        :price="1000"
                        v-for="(product, index) in products"
                        :key="index"
                    ></product-item>
                </div>
                <div
                    class="col"
                    v-for="p in placeholdersInRow(row)"
                    :key="'placeholder' + row + p"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductItem from "./ProductItem";
export default {
    components: {
        ProductItem
    },
    data() {
        return {
            loading: false,
            columns: 3,
            products: null
        };
    },
    methods: {
        productsInRow(row) {
            return this.products.slice(
                (row - 1) * this.columns,
                row * this.columns
            );
        },
        placeholdersInRow(row) {
            return this.columns - this.productsInRow(row).length;
        }
    },
    computed: {
        rows() {
            return this.products === null
                ? 0
                : Math.ceil(this.products.length / this.columns);
        }
    },
    created() {
        this.loading = true;
        setTimeout(() => {
            this.products = [
                {
                    id: 1,
                    title: "Item 1",
                    content: "This is item 1"
                }
            ];
            this.loading = false;
        }, 1500);
    }
};
</script>
