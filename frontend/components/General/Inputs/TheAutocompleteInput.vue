<template>
  <v-autocomplete
    :no-data-text="$t('no_data_autocomplete')"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
export default {
  props: {
    defaultValue: {
      type: [Array, String],
      default: null
    }
  },
  mounted () {
    if (this.defaultValue) {
      this.$emit('input', this.defaultValue)
    }
  }
}
</script>
