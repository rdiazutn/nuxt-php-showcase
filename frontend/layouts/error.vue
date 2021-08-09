<template>
  <v-container>
    <v-card color="transparent" elevation="0">
      <v-card-title>
        {{ $t('error_page.upps') }}
      </v-card-title>
      <v-card-subtitle class="mt-2">
        {{ error.statusCode === 404 ? $t('error_page.not_found') : $t('error_page.unexpected_error') }}
      </v-card-subtitle>
      <v-card-text>
        <NuxtLink class="custom-link" to="/">
          {{ $t('error_page.return_message') }}
        </NuxtLink>
      </v-card-text>
      <img class="mt-4" src="/error/error.png">
    </v-card>
  </v-container>
</template>

<script>
export default {
  layout: 'login',
  props: {
    error: {
      type: Object,
      default: () => ({})
    }
  }
}
</script>

<style scoped>
h1 {
  font-size: 20px;
}
</style>
