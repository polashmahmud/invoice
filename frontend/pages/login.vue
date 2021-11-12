<template>
    <div>
        <div class="home-btn d-none d-sm-block">
            <nuxt-link to="/" class="text-dark"><i class="mdi mdi-home-variant h2"></i></nuxt-link>
        </div>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <nuxt-link to="/" class="mb-5 d-block auth-logo">
                                <img src="~/assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark"/>
                                <img src="~/assets/images/logo-light.png" alt="" height="22" class="logo logo-light"/>
                            </nuxt-link>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to Minible.</p>
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

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <nuxt-link to="/auth/recoverpwd" class="text-muted">
                                                    Forgot password?
                                                </nuxt-link>
                                                <el-button
                                                    type="primary"
                                                    @click.prevent="submitForm('formRef')"
                                                    :loading="loading"
                                                >Log In</el-button>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 title">Sign in with</h5>
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
                                            <p class="mb-0">
                                                Don't have an account ?
                                                <nuxt-link to="/register" class="fw-medium text-primary">
                                                    Signup now
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
 * Login-1 component
 */
export default {
    layout: "auth",
    auth: 'guest',
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`
        };
    },
    data() {
        return {
            title: "Log in",

            formData: {
                email: "john@example.com",
                password: "password"
            },
            rules: {
                email: [
                    {
                        required: true,
                        message: "Please enter your email address",
                        trigger: "blur"
                    },
                    {
                        type: "email",
                        message: "Please enter a valid email address",
                        trigger: "blur"
                    }
                ],
                password: [
                    {
                        required: true,
                        message: "Please enter your password",
                        trigger: "blur"
                    }
                ]
            },
            loading: false
        };
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    this.callToLoginApi(formName);
                } else {
                    Notification.error('Please fill out the form correctly.')
                    return false;
                }
            });
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
                Notification.success(`Welcome ${this.formData.email}`);
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
};
</script>


