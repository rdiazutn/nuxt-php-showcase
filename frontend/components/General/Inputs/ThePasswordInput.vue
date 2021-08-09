<template>
  <TheTextInput
    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
    :type="showPassword ? 'text' : 'password'"
    :label="$t('password')"
    maxlength="32"
    prepend-icon="mdi-lock"
    v-bind="$attrs"
    v-on="$listeners"
    @click:append="showPassword = !showPassword"
  />
</template>

<script>
export default {
  data () {
    return {
      showPassword: false
    }
  }
}
</script>
