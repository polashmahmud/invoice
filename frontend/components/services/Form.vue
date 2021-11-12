<template>
    <el-dialog
        :title="title"
        :visible="open"
        width="450px"
        :show-close="false"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
    >
        <el-form
            :model="formData"
            :rules="rules"
            ref="formRef"
            label-width="120px"
            class="demo-ruleForm"
            label-position="top"
        >
            <el-form-item
                label="Service name"
                prop="name"
            >
                <el-input
                    v-model="formData.name"
                    autocomplete="off"
                    placeholder="Enter service name"
                />
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button
                @click.prevent="close"
            >Cancel</el-button>
            <el-button
                type="primary"
                @click.prevent="submit('formRef')"
                :loading="loading"
            >{{ actionBtnName }}</el-button>
        </span>
    </el-dialog>
</template>

<script>
import {Notification} from "element-ui";

export default {
    name: "Form",
    components: {Notification},
    props: {
        open: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: ''
        },
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            formData: {
                name: '',
            },
            rules: {
                name: [
                    { required: true, message: 'The name field is required' },
                ]
            },
            loading: false,
            actionBtnName: 'Add New',
        };
    },
    methods: {
        submit(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    if (this.formData.hasOwnProperty('id')) {
                        this.update()
                    } else {
                        this.addNew();
                    }
                } else {
                    Notification.info('Please fill up the form correctly')
                    return false;
                }
            });
        },

        async addNew() {
            this.loading = true;
            await this.$axios.post('services', this.formData)
            .then(response => {
                Notification.success('Successfully added');
                this.$emit('add', response.data.data);
            })
            .catch(() => {
                Notification.error('Something went wrong, Please try again later');
            })
            .finally(() => {
                this.loading = false;
                this.$refs['formRef'].resetFields();
                this.close();
            })
        },

        async update() {
            this.loading = true;
            await this.$axios.patch(`services/${this.formData.id}`, this.formData)
                .then(response => {
                    Notification.success('Successfully updated');
                    this.$emit('update', response.data.data);
                })
                .catch(() => {
                    Notification.error('Something went wrong, Please try again later');
                })
                .finally(() => {
                    this.loading = false;
                    this.$refs['formRef'].resetFields();
                    this.close();
                })
        },

        close() {
            this.$emit('close', false);
        }

    },
    watch: {
        item: {
            handler(value) {
               if (value.hasOwnProperty('id')) {
                   this.formData = _.cloneDeep(value);
                   this.actionBtnName = 'Update'
               }
            },
        }
    }
}
</script>

<style scoped>

</style>