<template>
  <TheFormDialog
    v-model="show"
    @onConfirm="confirm"
    @onCancel="cancel"
  >
    <template #activator="{ on , attrs }">
      <div class="px-3 border-solid-lightgray d-flex justify-space-between mb-4">
        <v-checkbox
          v-model="checkbox"
          v-bind="attrs"
          v-on="on"
        />
        <div class="mt-3">
          <TheButtonWithTooltip
            v-if="taxDeclaration.total_balance_to_use !== 0"
            icon="mdi-pencil"
            color="orange"
            :title="$t('edit')"
            v-on="on"
          />
        </div>
      </div>
    </template>
    <template>
      <TheAlertInfo text="tienen un 2" />
    </template>
  </TheFormDialog>
</template>

<script>
export default {
  props: {
    taxDeclaration: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    show: false,
    checkbox: false
  }),
  methods: {
    confirm () {
      this.$emit('completed')
      this.$emit('close')
    },
    cancel () {
      this.show = false
      this.checkbox = this.taxDeclaration.total_balance_to_use !== 0
    }
  }
}
</script>
