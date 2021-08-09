<template>
  <v-combobox
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
