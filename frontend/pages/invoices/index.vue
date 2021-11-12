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
                                        type="primary"
                                        icon="el-icon-document"
                                        @click.prevent="$router.push('/invoices/create')"
                                    >Add New Invoice</el-button>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>
                        <!-- Table -->
                        <invoice-table
                            :data="invoices"
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
    </div>
</template>

<script>
import InvoiceTable from '../../components/invoices/Table';

export default {
    name: "index",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {
        InvoiceTable
    },
    data() {
        return {
            title: "All Invoice",
            items: [{
                text: "Invoice",
            },
                {
                    text: "All",
                    active: true,
                },
            ],

            invoices: [],
            pagination: {currentPage: 1},
            loading: false,
            openAddModal: false,
            openEditModal: false,
            tempEditData: {}
        };
    },
    methods: {
        editModalAction() {

        }
    }
}
</script>

<style scoped>

</style>