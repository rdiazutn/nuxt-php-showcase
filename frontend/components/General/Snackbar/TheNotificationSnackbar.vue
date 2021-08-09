<template>
  <v-snackbar
    v-model="snackbar"
    :timeout="timeout"
    top
  >
    {{ text }}
    <template #action="{ attrs }">
      <v-btn
        color="blue"
        text
        v-bind="attrs"
        @click="snackbar = false"
      >
        {{ $t('close') }}
      </v-btn>
    </template>
  </v-snackbar>
</template>
<script>
export default {
  data: () => ({
    snackbar: false,
    text: 'Default text',
    timeout: -1
  }),
  methods: {
    show (text, timeout) {
      this.text = text
      this.timeout = timeout || this.timeout
      this.snackbar = true
    }
  }
}
</script>
