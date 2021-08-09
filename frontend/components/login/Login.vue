<template>
  <div>
    <v-card elevation="2">
      <ProgressLoading :loading="loading" />
      <v-form ref="form" v-model="valid" class="px-8" @submit.prevent="login()">
        <v-row justify="center">
          <v-col cols="auto" class="mt-8">
            <CompanyLogo :size="$vuetify.breakpoint.mdAndUp ? 'big' : 'medium-big'" />
          </v-col>
        </v-row>
        <v-card-title class="justify-center mt-8 headline-2">
          {{ $t('login.form_title') }}
        </v-card-title>
        <v-card-text>
          <v-row class="mt-3">
            <TheEmailInput v-model="credentials.email" :rules="[$rl.required()]" autofocus maxlength="32" />
          </v-row>
          <v-row>
            <ThePasswordInput v-model="credentials.password" :rules="[$rl.required()]" maxlength="32" />
          </v-row>
          <TheAlignedCenterText>
            <v-checkbox
              v-model="remember"
              :label="$t('login.remember_credentials')"
            />
          </TheAlignedCenterText>
        </v-card-text>
        <v-row>
          <v-col>
            <ThePrimaryButton
              :loading="loading"
              height="52"
              block
              type="submit"
              :inner-text="$t('login.access')"
            />
            <div class="mt-2">
              <NuxtLink to="/forget-password" class="custom-link-grey">
                {{ $t('login.forget_password') }}
              </NuxtLink>
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="body-1">
            {{ $t('login.register_message') }}
            <NuxtLink to="/register" class="custom-link">
              {{ $t('register_verb') }}
            </NuxtLink>
          </v-col>
        </v-row>
        <v-row justify="end">
          <v-col cols="auto" class="body-2 mb-2">
            {{ $t('taxmotor_name') }} &copy; {{ new Date().getFullYear() }}
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </div>
</template>
<style scoped>
.login-image {
  width: 25vw;
}
.divider-height{
  height: 100vh!important;
}
.font-size-20{
  font-size: 20px;
}
</style>
<script>
export default {
  data () {
    return {
      remember: false,
      loading: false,
      valid: false,
      credentials: {}
    }
  },
  methods: {
    login () {
      this.$refs.form.validate()
      if (!this.valid) {
        return
      }
      this.loading = true
      this.$auth.loginWith('laravelSanctum', {
        data: this.credentials
      }).then((res) => {
        this.$router.push('/')
      }).finally(() => { this.loading = false })
    }
  }
}
</script>
