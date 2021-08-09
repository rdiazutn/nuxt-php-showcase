<template>
  <v-progress-linear :color="loading ? 'primary' : 'transparent'" :indeterminate="loading" />
</template>
<script>
export default {
  props: {
    loading: {
      type: Boolean,
      required: true
    }
  }
}
</script>
