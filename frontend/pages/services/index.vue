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
                                    >Add New Service</el-button>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>
                        <!-- Table -->
                        <services-table
                            :data="services"
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

        <service-add-modal
            title="Add new service"
            :open="openAddModal"
            @close="closeModal"
            @add="services.unshift($event)"
        />

        <service-edit-modal
            title="Update service"
            :open="openEditModal"
            @close="closeModal"
            @update="update"
            :item="tempEditData"
        />
    </div>
</template>

<script>
import ServicesTable from "../../components/services/Table";
import ServiceAddModal from "../../components/services/Form";
import ServiceEditModal from "../../components/services/Form";
import {Notification} from "element-ui";

export default {
    name: "index",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {ServicesTable, ServiceAddModal, ServiceEditModal},
    data() {
        return {
            title: "All Service",
            items: [
                {
                    text: "Service",
                },
                {
                    text: "All",
                    active: true,
                },
            ],
            services: [],
            pagination: {currentPage: 1},
            loading: false,
            openAddModal: false,
            openEditModal: false,
            tempEditData: {}
        }
    },
    mounted() {
        this.getServices();
    },
    methods: {
        async getServices(page = 1) {
            this.loading = true;
            await this.$axios.get(`services?page=${page}`)
                .then(response => {
                    this.services = response.data.data;
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
            this.services.forEach((service, index) => {
                if (service.id === item.id) {
                    this.services.splice(index, 1);
                    this.services.unshift(item);
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
                this.getServices(page);
            }
        }
    }
}
</script>

<style scoped>

</style>