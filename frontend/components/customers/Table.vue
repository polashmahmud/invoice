<template>
    <div>
        <el-table
            :data="data"
            style="width: 100%"
            v-loading="loading"
        >
            <template slot="empty">
                <div>No data found</div>
            </template>
            <el-table-column
                prop="name"
                label="Name"
            >
            </el-table-column>
            <el-table-column
                prop="email"
                label="Email"
            >
            </el-table-column>


            <el-table-column
                align="right">
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        @click.prevent="edit(scope.row)"
                    >Edit
                    </el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click.prevent="open(scope.row.id)"
                    >Delete
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import {Table, TableColumn, Button, Notification} from 'element-ui';

export default {
    name: "CompanyTable",
    components: {
        ElTable: Table, ElTableColumn: TableColumn, ElButton: Button
    },
    props: {
        data: {
            type: Array,
            default: () => []
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        open(id) {
            this.$confirm('This will permanently delete. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.destroy(id);
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });
            });
        },

        async destroy(id) {
            await this.$axios.delete(`customers/${id}`)
                .then(() => {
                    this.data.forEach((item, index) => {
                        if (item.id === id) {
                            this.data.splice(index, 1);
                        }
                    })
                    this.$message({
                        type: 'success',
                        message: 'Delete completed'
                    });
                })
                .catch(() => {
                    Notification.error('Something went wrong, Please try again later.');
                })
        },

        edit(item) {
            this.$emit('edit', item);
        }

    }
}
</script>

<style scoped>

</style>