export default {
    // loading: "~/components/loading.vue",
    /*
     ** Nuxt rendering mode
     ** See https://nuxtjs.org/api/configuration-mode
     */
    ssr: false,
    /*
     ** Nuxt target
     ** See https://nuxtjs.org/api/configuration-target
     */
    target: "server",
    /*
     ** Headers of the page
     ** See https://nuxtjs.org/api/configuration-head
     */
    head: {
        meta: [
            {charset: "utf-8"},
            {name: "viewport", content: "width=device-width, initial-scale=1"},
            {
                hid: "description",
                name: "description",
                content: "Responsive Bootstrap 5 Admin Dashboard"
            }
        ],
        link: [{rel: "icon", type: "image/x-icon", href: "/favicon.ico"}]
    },
    router: {
        // linkExactActiveClass: 'active'
        middleware: ['auth']
    },
    /*
     ** Global CSS
     */
    css: [
        "~/assets/scss/app.scss",
        {src: 'element-ui/lib/theme-chalk/index.css'}
    ],
    /*
     ** Plugins to load before mounting the App
     ** https://nuxtjs.org/guide/plugins
     */
    plugins: [
        '~/plugins/lodash.js',
        {src: '~/plugins/element-ui', ssr: false},
        '~/plugins/i18n.js',
        "~/plugins/simplebar.js",
        "~/plugins/vue-click-outside.js",
        "~/plugins/vue-apexcharts.js",
        "~/plugins/vuelidate.js",
        "~/plugins/vue-slidebar.js",
        "~/plugins/vue-lightbox.js",
        "~/plugins/vue-chartist.js",
        "~/plugins/vue-mask.js",
        "~/plugins/vue-googlemap.js"
    ],
    /*
     ** Auto import components
     ** See https://nuxtjs.org/api/configuration-components
     */
    components: true,
    /*
     ** Nuxt.js dev-modules
     */
    buildModules: [
        '@nuxtjs/dotenv',
    ],
    /*
     ** Nuxt.js modules
     */
    modules: [
        // Doc: https://bootstrap-vue.js.org
        "bootstrap-vue/nuxt",
        // Doc: https://github.com/nuxt/content
        "@nuxt/content",
        '@nuxtjs/axios',
        '@nuxtjs/auth-next'
    ],
    /*
     ** Content module configuration
     ** See https://content.nuxtjs.org/configuration
     */
    content: {},
    /*
     ** Build configuration
     ** See https://nuxtjs.org/api/configuration-build/
     */
    build: {
        vendor: ['element-ui'],
    },
    env: {
        baseUrl: process.env.BASE_URL
    },

    axios: {
        credentials: true,
        baseURL: process.env.BASE_URL + '/api',
    },

    auth: {
        strategies: {
            'laravelJWT': {
                provider: 'laravel/jwt',
                url: process.env.BASE_URL + '/api',
                endpoints: {
                    login: {url: '/auth/login', method: 'post', propertyName: 'data.token'},
                    user: {url: '/auth/user', method: 'get', propertyName: 'data'},
                    refresh: {url: '/auth/refresh', method: 'post', propertyName: 'data'},
                    logout: false
                },
                token: {
                    property: 'access_token',
                    maxAge: 60 * 60
                },
                refreshToken: {
                    maxAge: 20160 * 60
                }
            },
        }
    },
};
