import colors from 'vuetify/es5/util/colors'
require('dotenv').config()
export default {
  // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
  ssr: false,
  server: {
    port: process.env.PORT,
    host: process.env.HOST
  },

  // Target (https://go.nuxtjs.dev/config-target)
  target: 'static',

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    titleTemplate: 'TM',
    title: 'frontend-taxmotor',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: ['~/assets/main.scss'],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    '~/plugins/i18n',
    '~/plugins/toasting',
    '~/plugins/services',
    '~/plugins/axios',
    '~/plugins/moment',
    '~/plugins/nuxt-client-init.client.js'
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify'
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    // Doc: https://github.com/nuxt-community/dotenv-module
    '@nuxtjs/dotenv',
    '@nuxtjs/proxy',
    '@nuxtjs/apollo'
  ],

  // Apollo setup
  apollo: {
    clientConfigs: {
      default: {
        httpEndpoint: process.env.GQL_ENDPOINT
      }
    }
  },

  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    proxy: process.env.ENVIROMENT === 'development',
    baseURL: process.env.API_ENDPOINT
  },
  proxy: {
    '/api': {
      target: process.env.API_ENDPOINT + '/',
      pathRewrite: {
        '^/api': '/'
      }
    }
  },

  // Vuetify module configuration (https://go.nuxtjs.dev/config-vuetify)
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      light: true,
      themes: {
        dark: {
          primary: colors.blue.accent3,
          accent: '#5389e6',
          secondary: '#03A9F4',
          terciary: '#6d29ff',
          complement: '#ff7f29',
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.darken2
        },
        light: {
          primary: '#326CEA',
          secondary: '#F8A463',
          accent: '#837DE9',
          terciary: '#6d29ff',
          complement: '#ff7f29',
          info: colors.blue.darken2,
          warning: colors.orange.darken2,
          error: colors.deepOrange.accent4,
          success: colors.green.darken2
        }
      }
    }
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
  },

  auth: {
    strategies: {
      laravelSanctum: {
        provider: 'laravel/sanctum',
        url: 'api',
        endpoints: {
          login: { url: '/api/auth/login', method: 'post' },
          logout: { url: '/api/auth/logout', method: 'post' },
          user: { url: '/api/auth/user', method: 'get' }
        },
        redirect: {
          login: '/',
          logout: '/',
          callback: '/',
          home: '/'
        }
      }
    }
  }
}
