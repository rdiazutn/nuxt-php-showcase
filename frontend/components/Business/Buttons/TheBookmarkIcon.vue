<template>
  <TheButtonWithTooltip :icon="icon" v-bind="$attrs" @click="toggle" v-on="$listeners" />
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
    icon () {
      return this.value ? 'mdi-star' : 'mdi-star-outline'
    }
  },
  methods: {
    toggle () {
      this.$emit('input', !this.value)
      this.$emit('toggle', this.value)
    }
  }
}
</script>
