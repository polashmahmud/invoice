<template>
    <div>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <nuxt-link to="/" class="mb-5 d-block auth-logo">
                                <img src="~/assets/images/logo-dark.png" alt height="22" class="logo logo-dark"/>
                                <img src="~/assets/images/logo-light.png" alt height="22" class="logo logo-light"/>
                            </nuxt-link>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Register Account</h5>
                                    <p class="text-muted">Get your free Minible account now.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <el-form
                                        :model="formData"
                                        :rules="rules"
                                        ref="formRef"
                                        label-width="120px"
                                        class="demo-ruleForm"
                                        label-position="top"
                                    >
                                        <el-form-item
                                            label="Username"
                                            prop="name"
                                        >
                                            <el-input
                                                v-model="formData.name"
                                                placeholder="Username"
                                            />
                                        </el-form-item>
                                        <el-form-item
                                            label="Email"
                                            prop="email"
                                        >
                                            <el-input
                                                v-model="formData.email"
                                                type="email"
                                                placeholder="Email"
                                            />
                                        </el-form-item>
                                        <el-form-item
                                            label="Password"
                                            prop="password"
                                        >
                                            <el-input
                                                v-model="formData.password"
                                                type="password"
                                                placeholder="Password"
                                            />
                                        </el-form-item>
                                        <el-form-item
                                            label="Re-Type Password"
                                            prop="password_confirmation"
                                        >
                                            <el-input
                                                v-model="formData.password_confirmation"
                                                type="password"
                                                placeholder="Re-Type Password"
                                            />
                                        </el-form-item>


                                        <div class="mt-3 text-end">
                                            <el-button
                                                type="primary"
                                                @click="submitForm('formRef')"
                                                :loading="loading"
                                            >Register
                                            </el-button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 title">Sign up using</h5>
                                            </div>

                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                       class="social-list-item bg-primary text-white border-primary">
                                                        <i class="mdi mdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                       class="social-list-item bg-info text-white border-info">
                                                        <i class="mdi mdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                       class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="text-muted mb-0">
                                                Already have an account ?
                                                <nuxt-link to="/auth/login-1" class="fw-medium text-primary">Login
                                                </nuxt-link>
                                            </p>
                                        </div>
                                    </el-form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>
                                © {{ new Date().getFullYear() }} Minible. Crafted with
                                <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    </div>
</template>

<script>
import {Notification} from 'element-ui';
/**
 * Register component
 */
export default {
    layout: "auth",
    auth: 'guest',
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    data() {
        let checkPasswordConfirmation = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password again'));
            } else if (value !== this.formData.password) {
                callback(new Error('Two inputs don\'t match!'));
            } else {
                callback();
            }
        };
        return {
            title: "Register",
            formData: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            rules: {
                name: [{required: true, message: 'The name field is required'}],
                email: [
                    {required: true, message: 'Please input email address'},
                    {type: 'email', message: 'Please input correct email address'}
                ],
                password: [
                    {required: true, message: 'The password field is required.'},
                    {min: 8, max: 25, message: 'Length should be 8 to 25'}
                ],
                password_confirmation: [{required: true, validator: checkPasswordConfirmation}],
            },
            loading: false,

        };
    },

    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    this.callToRegisterApi(formName);
                } else {
                    Notification.error('Please fill out the form correctly.')
                    return false;
                }
            });
        },
        async callToRegisterApi(formName) {
            try {
                await this.$axios.post('/register', this.formData);
                await this.callToLoginApi();
                this.$refs[formName].resetFields();
                this.loading = false;
                Notification.success('Account create successfully.');
            } catch (errors) {
                let err = errors.response.data.errors;
                for (let field of Object.keys(err)) {
                    Notification.error(err[field][0])
                }
                this.loading = false;
            }
        },

        async callToLoginApi() {
            try {
                await this.$auth.loginWith('laravelJWT', {
                    data: {
                        email: this.formData.email,
                        password: this.formData.password
                    }
                });
                await this.$router.push('/');
                Notification.success(`Welcome ${this.formData.name}`);
                this.loading = false;
            } catch (errors) {
                let err = errors.response.data.errors;
                for (let field of Object.keys(err)) {
                    Notification.error(err[field][0])
                }
                this.loading = false;
            }
        }

    }
}
;
</script>


