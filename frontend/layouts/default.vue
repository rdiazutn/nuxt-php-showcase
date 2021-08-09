<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      color="white"
      :permanent="$vuetify.breakpoint.mdAndUp"
      :mini-variant="activeMini && $vuetify.breakpoint.mdAndUp && !drawer"
      clipped
      fixed
      app
      class="pt-5"
    >
      <v-list expand class="mt-1">
        <template v-for="(item,i) in menus">
          <MenuDrawerContent :key="i + 'A'" class="py-2" :item="item" />
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar clipped-left color="white" app height="80px">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <span>
        <CompanyLogo size="medium-big" class="ml-6 pb-3 pt-4" />
      </span>
      <v-spacer />
      <TheInformationDialog :title="$t('layout_default.information_title')" :text="$t('layout_default.information')">
        <template #activator="{on, attrs}">
          <TheButtonWithTooltip
            :top="false"
            bottom
            :title="$t('layout_default.information_title')"
            color="primary"
            icon="mdi-information-variant"
            v-bind="attrs"
            v-on="on"
          />
        </template>
      </TheInformationDialog>
      <AvatarUserMenu />
    </v-app-bar>
    <v-main class="bg-default">
      <v-container class="px-10">
        <nuxt />
      </v-container>
    </v-main>
    <v-footer
      app
      clipped
      color="white"
    >
      <TheNotificationSnackbar ref="snackbar" />
      <v-row justify="end">
        <v-col sm="auto">
          <span class="body-1">
            {{ $t('taxmotor_name') }} &copy; {{ new Date().getFullYear() }}
          </span>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
      drawer: false,
      activeMini: false
    }
  },
  computed: {
    menus () {
      return [
        {
          title: 'home.menu',
          icon: 'mdi-home',
          to: '/'
        },
        {
          title: 'home.profile',
          icon: 'mdi-account',
          to: '/profile'
        },
        {
          title: 'home.documents',
          icon: 'mdi-folder',
          to: '/documents'
        },
        {
          title: 'home.taxes',
          icon: 'mdi-gavel',
          children: [
            {
              title: 'home.dashboard',
              to: '/taxes/dashboard'
            },
            {
              title: 'home.historic',
              to: '/taxes/historic'
            }
          ]
        },
        {
          title: 'home.account',
          icon: 'mdi-shield-account',
          to: '/account'
        }
      ]
    }
  },
  created () {
    this.$notification.attach(this)
  },
  mounted () {
    setTimeout(() => {
      this.activeMini = true
    }, 25)
  },
  methods: {
    showSnackbar (text, timeout) {
      this.$refs.snackbar.show(text, timeout)
    }
  }
}
</script>
