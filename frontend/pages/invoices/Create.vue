<template>
    <div>
        <PageHeader
            :title="title"
            :items="items"
        />

        <el-form
            :model="formData"
            :rules="rules"
            ref="formRef"
            label-width="120px"
            class="demo-ruleForm"
            label-position="top"
        >

            <div class="row">
                <div class="col-12">
                    <div class="py-3 d-flex justify-content-end">
                        <el-button>Preview</el-button>
                        <el-button type="primary">Save</el-button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between">
                            <h6>Customer Information</h6>
                            <el-button
                                icon="el-icon-edit"
                                plain
                                type="primary"
                                size="mini"
                                @click.prevent="openCustomerEditModal = true"
                                :disabled="formData.hasOwnProperty('customer') && !formData.customer.hasOwnProperty('id')"
                            >Edit Customer Details
                            </el-button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <el-form-item
                                        label="Select customer"
                                        prop="customer"
                                    >
                                        <dynamic-customer-selector
                                            @add-new="openCustomerAddModal = true"
                                            :new-element="formData.customer"
                                            @getDate="formData.customer = $event"
                                        />
                                    </el-form-item>
                                </div>

                                <div class="col-6">
                                    <el-form-item
                                        label="Invoice number"
                                        prop="invoice_no"
                                    >
                                        <el-input
                                            autocomplete="off"
                                            placeholder="Enter Invoice Number"
                                            v-model="formData.invoice_no"
                                        />
                                    </el-form-item>

                                    <div class="row">
                                        <div class="col-6">
                                            <el-form-item
                                                label="Invoice create date"
                                                prop="invoice_date"
                                            >
                                                <el-date-picker
                                                    type="date"
                                                    placeholder="Pick a day"
                                                    style="width: 100%"
                                                    v-model="formData.invoice_date"
                                                />

                                            </el-form-item>
                                        </div>
                                        <div class="col-6">
                                            <el-form-item
                                                label="Invoice due date"
                                                props="invoice_due_date"
                                            >
                                                <el-date-picker
                                                    type="date"
                                                    placeholder="Pick a day"
                                                    style="width: 100%"
                                                    v-model="formData.invoice_due_date"
                                                />

                                            </el-form-item>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between">
                            <h6>Item Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <product-selector @products="formData.products = $event"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between">
                            <h6>Upload your attachments</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <el-upload
                                            :headers="headers"
                                            class="upload-demo"
                                            drag
                                            action="http://localhost:8000/api/upload-temp-files?folder=invoice"
                                            :on-preview="handlePictureCardPreview"
                                            :on-remove="handleRemove"
                                            :on-success="handleUploadSuccess"
                                            :file-list="fileList"
                                            multiple>
                                            <i class="el-icon-upload"></i>
                                            <div class="el-upload__text">Drop file here or <em>click to upload</em>
                                            </div>
                                        </el-upload>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between">
                            <h6>Notes</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <el-form-item
                                        prop="notes"
                                    >
                                        <el-input
                                            type="textarea"
                                            :rows="4"
                                            placeholder="Enter your notes here"
                                            v-model="formData.notes"
                                        />
                                    </el-form-item>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="py-3 d-flex justify-content-end">
                        <el-button>Preview</el-button>
                        <el-button
                            type="primary"
                            @click.prevent="submitForm('formRef')"
                        >Save</el-button>
                    </div>
                </div>
            </div>

        </el-form>

        <customer-add-modal
            title="Add new customer"
            :open="openCustomerAddModal"
            @close="openCustomerAddModal = false"
            @add="addNewCustomer"
        />

        <customer-edit-modal
            title="Update customer"
            :open="openCustomerEditModal"
            @close="openCustomerEditModal = false"
            @update="editCustomer"
            :item="formData.customer"
        />

    </div>
</template>

<script>
import DynamicCustomerSelector from "@/components/common/DynamicCustomerSelector.vue";
import CustomerAddModal from "../../components/customers/Form";
import CustomerEditModal from "../../components/customers/Form";
import ProductSelector from "../../components/invoices/ProductSelector";
import {Notification} from "element-ui";

export default {
    name: "Create",
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    components: {
        DynamicCustomerSelector, CustomerAddModal, CustomerEditModal, ProductSelector
    },
    data() {
        return {
            title: "All Invoice",
            items: [{
                text: "Invoice",
            },
                {
                    text: "Create",
                    active: true,
                },
            ],

            openCustomerAddModal: false,
            openCustomerEditModal: false,

            formData: {
                customer: {},
                invoice_no: "",
                invoice_date: new Date(),
                invoice_due_date: "",
                notes: "",
                products: [],
                files: []
            },
            rules: {
                invoice_no: [{required: true, message: 'The Invoice no field is required', trigger: 'blur'}],
                invoice_date: [{required: true, message: 'The Invoice date field is required', trigger: 'blur'}],
                customer: [{required: true, message: 'The Invoice date field is required', trigger: 'blur'}],
            },

            dialogImageUrl: '',
            dialogVisible: false,

            fileList: [],

            headers: {
                'Authorization': this.$auth.strategy.token.get(),
            },
        };
    },
    methods: {
        handleUploadSuccess(path) {
            this.formData.files.push(path);
        },
        async handleRemove(file) {
            let index = this.formData.files.indexOf(file.response);
            this.formData.files.splice(index, 1);
            await this.$axios.delete(`/upload-temp-files/${file.response.id}`)
                .then(() => {
                    Notification.success('Delete Successfully');
                })
                .catch(() => {
                    Notification.error('Delete Failed');
                });
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },

        addNewCustomer(customer) {
            this.formData.customer = customer;
            this.openCustomerAddModal = false;
        },

        editCustomer(customer) {
            this.formData.customer = customer;
            this.openCustomerEditModal = false;
        },

        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    this.callToCreateApi(formName);
                } else {
                    Notification.error('Please fill out the form correctly.')
                    return false;
                }
            });
        },

        async callToCreateApi(formName) {
            await this.$axios.post('/invoices', this.formData)
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>

</style>
