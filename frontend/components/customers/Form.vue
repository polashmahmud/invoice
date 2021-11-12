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
                label="Customer name"
                prop="name"
            >
                <el-input
                    v-model="formData.name"
                    autocomplete="off"
                    placeholder="Enter customer name"
                />
            </el-form-item>
            <el-form-item
                label="Customer email"
                prop="email"
            >
                <el-input
                    v-model="formData.email"
                    autocomplete="off"
                    placeholder="Enter customer email"
                    :disabled="!!formData.hasOwnProperty('id')"
                    type="email"
                />
            </el-form-item>
            <el-form-item
                v-if="formData.hasOwnProperty('password')"
                label="Password"
                prop="password"
            >
                <el-input
                    v-model="formData.password"
                    autocomplete="off"
                    type="password"
                    placeholder="Enter password"
                />
            </el-form-item>
            <el-form-item
                v-if="formData.hasOwnProperty('password_confirmation')"
                label="Password Confirmation"
                prop="password_confirmation"
            >
                <el-input
                    v-model="formData.password_confirmation"
                    autocomplete="off"
                    type="password"
                    placeholder="Re-type password"
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
        const password = (rule, value, callback) => {
            if (value.length < 8) {
                callback(new Error('Password must be at least 8 characters'));
            } else {
                this.$refs.formRef.validateField('password_confirmation');
                callback();
            }
        };

        const confirmPassword = (rule, value, callback) => {
            if (value.length < 8) {
                callback(new Error('Please confirm your password'));
            } else if (value !== this.formData.password) {
                callback(new Error('Your password does not match'));
            } else {
                callback();
            }
        };

        return {
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            rules: {
                name: [
                    { required: true, message: 'The name field is required' },
                ],
                email: [
                    { required: true, message: 'The email field is required' },
                    { type: 'email', message: 'Please input correct email address' }
                ],
                password: [
                    { validator: password, required: true, }
                ],
                password_confirmation: [
                    { validator: confirmPassword, required: true, }
                ],
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
            await this.$axios.post('customers', this.formData)
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
            await this.$axios.patch(`customers/${this.formData.id}`, this.formData)
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