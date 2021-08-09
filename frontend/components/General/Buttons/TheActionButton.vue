<template>
  <TheButton
    text
    fab
    :small="small"
    :x-small="xSmall"
    depressed
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
export default {
  props: {
    xSmall: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    small () {
      return !this.xSmall
    }
  }
}
</script>
