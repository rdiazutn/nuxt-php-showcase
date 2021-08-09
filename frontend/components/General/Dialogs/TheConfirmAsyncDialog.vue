<template>
  <TheDialog
    v-model="showDialog"
    v-bind="$attrs"
    :loading="loading"
    max-width="600"
    v-on="$listeners"
    @cancel="cancel"
  >
    <template #activator="{on}">
      <slot name="activator" :on="on" />
    </template>
    <template>
      <v-card-text class="pt-8">
        {{ bodyMessage }}
        <slot name="body" />
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <TheSecondaryButton
          v-if="!loading"
          :inner-text="cancelButton"
          :loading="loading"
          @click="cancel"
        />
        <ThePrimaryButton
          :inner-text="confirmButton"
          :loading="loading"
          @click="confirm"
        />
      </v-card-actions>
    </template>
  </TheDialog>
</template>
<script>
export default {
  props: {
    bodyMessage: {
      type: String,
      default: ''
    },
    confirmButton: {
      type: String,
      default: 'Aceptar'
    },
    asyncConfirmFunction: {
      type: Function,
      required: true
    },
    cancelButton: {
      type: String,
      default: 'Cancelar'
    },
    okMessage: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      showDialog: false,
      loading: false
    }
  },
  methods: {
    confirm () {
      this.loading = true
      this.asyncConfirmFunction().then((result) => {
        if (result) {
          this.showDialog = false
          this.$emit('onConfirm')
          if (this.okMessage) {
            this.toastSuccess(this.$t(this.okMessage))
          }
        }
      }).finally(this.stopLoading)
    },
    stopLoading () {
      this.loading = false
    },
    cancel () {
      this.showDialog = false
      this.$emit('onCancel')
    }
  }
}
</script>
