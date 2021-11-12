<template>
    <div>
        <PageHeader
            :title="title"
            :items="items"
        />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3 pb-4 border-bottom">
                            <div class="col-sm-12 col-md-6">
                                <el-input
                                    placeholder="Search something..."
                                >
                                    <i slot="suffix" class="el-input__icon el-icon-search"></i>
                                </el-input>
                            </div>
                            <!-- Search -->
                            <div class="col-sm-12 col-md-6">
                                <div style="text-align: end">
                                    <el-button
                                        @click.prevent="openAddModal = true"
                                    >Add New Customer</el-button>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>
                        <!-- Table -->
                        <customer-table
                            :data="customers"
                            :loading="loading"
                            @edit="editModalAction"
                        />
                        <div class="row">
                            <div class="col">
                                <div class="dataTables_paginate paging_simple_numbers float-end">
                                    <ul class="pagination pagination-rounded mb-0 mt-3">
                                        <!-- pagination -->
                                        <b-pagination
                                            v-model="pagination.currentPage"
                                            :total-rows="pagination.total"
                                            :per-page="pagination.perPage"
                                        ></b-pagination>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <customer-add-modal
            title="Add new customer"
            :open="openAddModal"
            @close="closeModal"
            @add="customers.unshift($event)"
        />

        <customer-edit-modal
            title="Update company"
            :open="openEditModal"
            @close="closeModal"
            @update="update"
            :item="tempEditData"
        />
    </div>
</template>

<script>
import CustomerTable from "../../components/customers/Table";
import CustomerAddModal from "../../components/customers/Form";
import CustomerEditModal from "../../components/customers/Form";
import {Notification} from "element-ui";

export default {
    name: "index",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {CustomerTable, CustomerAddModal, CustomerEditModal},
    data() {
        return {
            title: "All Customer",
            items: [
                {
                    text: "Customer",
                },
                {
                    text: "All",
                    active: true,
                },
            ],
            customers: [],
            pagination: {currentPage: 1},
            loading: false,
            openAddModal: false,
            openEditModal: false,
            tempEditData: {}
        }
    },
    mounted() {
        this.getCustomers();
    },
    methods: {
        async getCustomers(page = 1) {
            this.loading = true;
            await this.$axios.get(`customers?page=${page}`)
                .then(response => {
                    this.customers = response.data.data;
                    this.pagination = {
                        currentPage: response.data.current_page,
                        perPage: response.data.per_page,
                        total: response.data.total
                    };
                })
                .catch(() => {
                    Notification.error('Something went wrong, Please try again later.')
                })
                .finally(() => {
                    this.loading = false
                })
        },

        editModalAction(item) {
            this.tempEditData = item;
            this.openEditModal = true;
        },

        update(item) {
            this.customers.forEach((customer, index) => {
                if (customer.id === item.id) {
                    this.customers.splice(index, 1);
                    this.customers.unshift(item);
                }
            })
        },

        closeModal() {
            this.tempEditData = {};
            this.openAddModal = false;
            this.openEditModal = false;
        }
    },
    watch: {
        'pagination.currentPage': {
            handler(page) {
                this.getCustomers(page);
            }
        }
    }
}
</script>

<style scoped>

</style>