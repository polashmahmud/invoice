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
                                    <el-button @click.prevent="openAddModal = true">Add New Company</el-button>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>
                        <!-- Table -->
                        <company-table
                            :data="companies"
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

        <company-add-modal
            title="Add new company"
            :open="openAddModal"
            @close="closeModal"
            @add="companies.unshift($event)"
        />

        <company-edit-modal
            title="Update company"
            :open="openEditModal"
            @close="closeModal"
            @update="update"
            :item="tempEditData"
        />

    </div>
</template>

<script>
import {Input, Button, Notification} from 'element-ui';
import CompanyTable from "../../components/companies/Table";
import CompanyAddModal from "../../components/companies/Form";
import CompanyEditModal from "../../components/companies/Form";

export default {
    name: "companies",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {
        CompanyTable, CompanyAddModal, CompanyEditModal,
        ElInput: Input, ElButton: Button,
    },
    data() {
        return {
            title: "All Company",
            items: [
                {
                    text: "Company",
                },
                {
                    text: "All",
                    active: true,
                },
            ],
            companies: [],
            pagination: {currentPage: 1},
            loading: false,
            openAddModal: false,
            openEditModal: false,
            tempEditData: {}
        };
    },
    mounted() {
        this.getCompanies();
    },
    methods: {
        async getCompanies(page = 1) {
            this.loading = true;
            await this.$axios.get(`companies?page=${page}`)
                .then(response => {
                    this.companies = response.data.data;
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
            this.companies.forEach((company, index) => {
                if (company.id === item.id) {
                    this.companies.splice(index, 1);
                    this.companies.unshift(item);
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
                this.getCompanies(page);
            }
        }
    }
}
</script>

<style scoped>

</style>