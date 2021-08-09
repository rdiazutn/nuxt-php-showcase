<template>
  <TheDialog
    v-bind="$attrs"
    v-on="$listeners"
  >
    <v-card-title class="headline">
      {{ headerMessage }}
    </v-card-title>
    <v-card-text>
      {{ bodyMessage }}
      <slot />
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <TheSecondaryButton
        :inner-text="cancelButton"
        @click="cancel"
      />
      <ThePrimaryButton
        :inner-text="confirmButton"
        @click="confirm"
      />
    </v-card-actions>
  </TheDialog>
</template>
<script>
export default {
  props: {
    headerMessage: {
      type: String,
      default: 'headerMessage'
    },
    bodyMessage: {
      type: String,
      default: 'bodyMessage'
    },
    confirmButton: {
      type: String,
      default: 'Aceptar'
    },
    cancelButton: {
      type: String,
      default: 'Cancelar'
    },
    goToConfirm: {
      type: String,
      default: '#labelResponse'
    }
  },
  methods: {
    confirm () {
      this.$emit('onConfirm')
    },
    cancel () {
      this.$emit('onCancel')
    }
  }
}
</script>
