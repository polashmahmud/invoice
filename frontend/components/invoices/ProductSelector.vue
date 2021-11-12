<template>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Description</th>
                <th width="150px">Quantity</th>
                <th width="150px">Rate($)</th>
                <th>Amount</th>
                <th width="25px"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in products" :key="index">
                <th scope="row">
                    <span v-text="index + 1"></span>
                </th>
                <td>
                    <el-form-item :error="product.nameError">
                        <el-select
                            style="width: 100%"
                            v-model="product.name"
                            filterable
                            remote
                            clearable
                            allow-create
                            reserve-keyword
                            placeholder="Please search or add new product"
                            loading-text="Loading..."
                            :remote-method="remoteMethod"
                            :loading="loading"
                            @blur="blurProductNameField(index)"
                        >
                            <el-option
                                v-for="item in remoteProducts"
                                :key="item.id"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>

                </td>
                <td>
                    <el-input v-model="product.description"/>
                </td>
                <td>
                    <el-input min="1" v-model="product.quantity" type="number"/>
                </td>
                <td>
                    <el-input min="0" v-model="product.rate" type="number"/>
                </td>
                <td>
                    <strong>${{ product.quantity * product.rate }}</strong>
                </td>
                <td>
                    <el-button
                        @click.prevent="deleteProduct(index)"
                        type="text"
                        :disabled="index === 0"
                    >
                        <i class="el el-icon-delete"></i>
                    </el-button>
                </td>
            </tr>
            </tbody>
        </table>

        <el-button
            class="mt-3"
            type="text"
            @click.prevent="addNewProduct"
            :disabled="foundError"
        >+ Add New Product
        </el-button>
    </div>
</template>

<script>
export default {
    name: "ProductSelector",
    data() {
        return {
            products: [
                {
                    id: this.generateId(),
                    name: "",
                    description: "",
                    quantity: 1,
                    rate: 0,

                    nameError: ""
                }
            ],
            remoteProducts: [],
            loading: false,

            tempName: "",

            foundError: false
        }
    },
    mounted() {
        // this.getProducts();
    },
    methods: {
        async getProducts(search = '') {
            await this.$axios.get(`products?search=${search}`)
                .then(response => {
                    this.remoteProducts = response.data.data;
                })
        },
        remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.tempName = query;
                    this.getProducts(query);
                }, 200);
            } else {
                this.options = [];
            }
        },
        blurProductNameField(index) {
            if (this.products[index].name === "") {
                this.products[index].name = this.tempName;
                this.tempName = "";
            }
        },
        addNewProduct() {
            this.products.push({
                id: this.generateId(),
                name: "",
                description: "",
                quantity: 1,
                rate: 0,
            });
        },
        deleteProduct(index) {
            this.products.splice(index, 1);
        },
        generateId() {
            return Date.now().toString(36) + Math.random().toString(36).substring(2)
        }
    },
    watch: {
        products: {
            handler() {
                this.$emit('products', this.products);
                this.foundError = false;
                this.products.forEach((product, index) => {
                    if (product.name === "") {
                        this.products[index].nameError = "Product name is required";
                        this.foundError = true;
                    } else {
                        this.products[index].nameError = "";
                    }
                });
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>