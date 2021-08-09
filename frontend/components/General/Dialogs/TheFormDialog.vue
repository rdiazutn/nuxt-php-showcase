<template>
  <TheDialog
    v-bind="$attrs"
    :loading="loading"
    v-on="$listeners"
    @cancel="cancel"
  >
    <template #activator="{on}">
      <slot name="activator" :on="on" />
    </template>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
        :readonly="loading || readonly"
        class="pt-2"
        @submit.prevent="confirm"
      >
        <input type="submit" value="Submit" class="hideInput">
        <slot />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <TheSecondaryButton
        v-if="showSecondaryButton"
        :inner-text="$t(readonly ? closeText : cancelButton)"
        @click="cancel"
      />
      <ThePrimaryButton
        v-if="!readonly"
        :inner-text="$t(confirmButton)"
        :loading="loading"
        :disabled="!canConfirm"
        @click="confirm"
      />
    </v-card-actions>
  </TheDialog>
</template>
<script>
export default {
  props: {
    confirmButton: {
      type: String,
      default: 'save'
    },
    cancelButton: {
      type: String,
      default: 'cancel'
    },
    closeText: {
      type: String,
      default: 'close'
    },
    loading: {
      type: Boolean,
      default: false
    },
    readonly: {
      type: Boolean,
      default: false
    },
    showSecondaryButton: {
      type: Boolean,
      default: true
    },
    canConfirm: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      valid: true
    }
  },
  methods: {
    confirm () {
      this.$refs.form.validate()
      if (this.valid) {
        if (!this.readonly) {
          this.$emit('onConfirm')
        } else {
          this.$emit('onCancel')
        }
      } else {
        this.toastError('Revise los campos para proceder')
      }
    },
    resetValidation () {
      if (this.$refs.form) {
        this.$refs.form.resetValidation()
      }
    },
    cancel () {
      this.$emit('onCancel')
      this.resetValidation()
    }
  }
}
</script>
