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
                                    >Add New Server</el-button>
                                </div>
                            </div>
                            <!-- End search -->
                        </div>
                        <!-- Table -->
                        <websites-table
                            :data="websites"
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

        <website-add-modal
            title="Add new website"
            :open="openAddModal"
            @close="closeModal"
            @add="websites.unshift($event)"
        />

        <website-edit-modal
            title="Update website"
            :open="openEditModal"
            @close="closeModal"
            @update="update"
            :item="tempEditData"
        />
    </div>
</template>

<script>
import WebsitesTable from "../../components/websites/Table";
import WebsiteAddModal from "../../components/websites/Form";
import WebsiteEditModal from "../../components/websites/Form";
import {Notification} from "element-ui";

export default {
    name: "index",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {WebsitesTable, WebsiteAddModal, WebsiteEditModal},
    data() {
        return {
            title: "Servers",
            items: [
                {
                    text: "Server",
                },
                {
                    text: "All",
                    active: true,
                },
            ],
            websites: [],
            pagination: {currentPage: 1},
            loading: false,
            openAddModal: false,
            openEditModal: false,
            tempEditData: {}
        }
    },
    mounted() {
        this.getWebsites();
    },
    methods: {
        async getWebsites(page = 1) {
            this.loading = true;
            await this.$axios.get(`websites?page=${page}`)
                .then(response => {
                    this.websites = response.data.data;
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
            this.websites.forEach((website, index) => {
                if (website.id === item.id) {
                    this.websites.splice(index, 1);
                    this.websites.unshift(item);
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
                this.getWebsites(page);
            }
        }
    }
}
</script>

<style scoped>

</style>
