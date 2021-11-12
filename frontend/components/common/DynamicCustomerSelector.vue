<template>
    <section class="auto-fill" v-click-outside="onClickOutside">
        <div class="description" @click.prevent="showList">
            <div v-if="selectedData.hasOwnProperty('id')">
                <strong v-if="selectedData.hasOwnProperty('name')">
                    {{ selectedData.name }}
                </strong>
                <span v-if="selectedData.hasOwnProperty('email')">{{ selectedData.email }}</span>
            </div>
            <div class="not-found" v-else style="color: #919191;">
                Select a customer
            </div>
        </div>

        <div class="content-section" :class="showChild ? 'd-block' : 'd-none'">
            <div class="search mb-2">
                <span class="mr-2">
                    <i v-if="changeSearchIcon" class="el-icon-loading"/>
                     <i v-else style="width: 18px; height: 18px" class="el el-icon-search"></i>
                </span>
                <input
                    type="text"
                    v-model="search"
                    placeholder="Search customer name"
                />
            </div>

            <el-table
                :data="data"
                v-loading="loading"
                style="width: 100%"
                height="250"
                header-row-class-name="ted-table-header-row"
                row-class-name="ted-table-row pointer"
                @row-click="handleClick"
                v-el-table-infinite-scroll="scrollLoadData"
                cell-class-name="border-less"
                :show-header="false"
            >
                <template slot="empty">
                    <nothing-to-show margin-top="4"/>
                </template>
                <el-table-column prop="name"/>
            </el-table>

            <div class="text-center">
                <div
                    @click.prevent="addNew"
                    class="add-new-btn"
                >
                    Add New
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NothingToShow from "@/components/common/NothingToShow.vue";
import elTableInfiniteScroll from "el-table-infinite-scroll";
import vClickOutside from 'v-click-outside';
import {Notification} from 'element-ui';

export default {
    name: "DynamicCustomerSelector",
    components: {
        NothingToShow, vClickOutside
    },
    directives: {
        "el-table-infinite-scroll": elTableInfiniteScroll
    },
    props: {
        newElement: {
            type: [Object, Array],
            default: () => ({})
        }
    },
    data() {
        return {
            search: "",
            timer: null,
            changeSearchIcon: false,
            showChild: false,
            selectedData: {},
            loading: false,
            data: [],
            pagination: {last_page: 1, current_page: 1},
            printables: [],
        }
    },
    methods: {
        showList() {
            this.showChild = true;
            this.callToGetApi();
        },

        addNew() {
            this.$emit('add-new', true);
            this.showChild = false;
        },
        handleClick(selectedData) {
            this.selectedData = selectedData;
            this.showChild = false;
        },
        scrollLoadData() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.loading = true;
                setTimeout(() => {
                    this.callToGetApi(
                        this.pagination.current_page + 1,
                        this.search
                    );
                    this.loading = false;
                }, 800);
            }
        },
        onClickOutside(event) {
            if (this.showChild) {
                this.showChild = false;
            }
        },
        async callToGetApi(page = 1, search = "") {
            this.loading = true;

            await this.$axios.get(`customers?page=${page}&search=${search}`)
                .then(response => {
                    this.data = [];
                    response.data.data.forEach(item => {
                        this.data.push(item);
                    });

                    this.pagination = {
                        last_page: response.data.last_page,
                        current_page: response.data.current_page,
                        per_page: response.data.per_page,
                        total: response.data.total
                    };
                })
                .finally(() => {
                    this.loading = false;
                })
                .catch(() => {
                    Notification.error("Failed to fetch data");
                });
        },
        searchWithTimer(search) {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.callToGetApi(1, search);
                this.timer = null;
            }, 800);
        },
    },
    watch: {
        selectedData(value) {
            this.$emit("getDate", value);
        },
        newElement(newItem) {
            if (newItem.hasOwnProperty("id")) {
                this.selectedData = newItem;
            }
        }
    }
}
</script>

<style scoped lang="scss">
.auto-fill {
    background: rgba(55, 59, 79, 0.03);
    border: 0.5px solid rgba(171, 175, 180, 0.7);
    box-sizing: border-box;
    border-radius: 5px;

    line-height: normal;
    padding: 5px 10px;
    font-size: 12px;
    color: var(--dark);
    position: relative;
    cursor: pointer;

    .description,
    .not-found {
        min-height: 100px;
        font-size: 12px;
    }

    span {
        display: block;
    }

    .content-section {
        position: absolute;
        top: 40px;
        left: 0;
        width: 100%;
        background: linear-gradient(0deg, #ffffff, #ffffff), #f39c12;
        box-shadow: 0px 16px 50px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 20px;
        z-index: 999;
        cursor: initial;

        .search {
            padding: 15px 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(55, 59, 79, 0.03);
            border: 0.5px solid rgba(171, 175, 180, 0.7);
            box-sizing: border-box;
            border-radius: 5px;

            input[type="text"] {
                font-size: 14px;
                line-height: 16px;
                width: 95%;
                border: none;
                background: transparent;

                &:focus {
                    outline: none;
                }
            }
        }

        .add-new-btn {
            font-size: 12px;
            color: #008aff;
            padding: 10px;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }
    }
}
</style>