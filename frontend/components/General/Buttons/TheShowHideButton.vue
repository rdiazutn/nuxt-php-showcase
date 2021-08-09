<template>
  <TheButtonWithTooltip
    color="secondary"
    :title="show ? $t('show') : $t('hide')"
    :icon="show ? 'mdi-chevron-up' : 'mdi-chevron-down'"
    @click="show = !show"
  />
</template>
<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    show: {
      get () {
        return this.value
      },
      set (val) {
        this.$emit('input', val)
      }
    }
  }
}
</script>
